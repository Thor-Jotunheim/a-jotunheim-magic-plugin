<?php
// REST endpoint for Valheim weather: /wp-json/jotunheim/v1/weather
if (!defined('ABSPATH')) exit;

add_action('rest_api_init', function() {
    register_rest_route('jotunheim/v1', '/weather', array(
        'methods' => 'GET',
        // The handler function is defined in the global namespace in this file
        'callback' => 'jotunheim_weather_rest_handler',
        'args' => array(
            'day' => array('required' => false, 'default' => 1, 'sanitize_callback' => 'absint'),
            'seed' => array('required' => false, 'sanitize_callback' => 'sanitize_text_field')
        ),
        'permission_callback' => function() { return true; }
    ));
});

function jotunheim_get_numeric_seed_from_string($seedStr) {
    if (!$seedStr) return 0;
    if (is_numeric($seedStr)) return intval($seedStr) & 0x7FFFFFFF;
    $h = crc32($seedStr);
    return $h & 0x7FFFFFFF;
}

function jotunheim_weather_rest_handler($request) {
    $day = isset($request['day']) ? intval($request['day']) : 1;
    $seedParam = isset($request['seed']) ? $request['seed'] : '';

    // compute base tick: use GAME_DAY=1800 seconds; sample tick use day*3600 to match prior usage
    $tick = max(0, $day) * 3600;

    // derive numeric seed: if override provided use it, otherwise use stored option helper
    if ($seedParam) {
        $numericSeed = jotunheim_get_numeric_seed_from_string($seedParam);
    } else {
        // try calling the plugin helper (namespaced) if available
        if (function_exists('\\Jotunheim\\Utility\\jotunheim_get_numeric_seed')) {
            $numericSeed = \Jotunheim\Utility\jotunheim_get_numeric_seed();
        } else {
            $numericSeed = 0;
        }
    }

    // compute wind and weather using the same math as the PHP generator (without double-reading option)
    // Ensure generator code is loaded
    if (!class_exists('\\Jotunheim\\Utility\\Yj') || !function_exists('\\Jotunheim\\Utility\\og') || !function_exists('\\Jotunheim\\Utility\\ng')) {
        // attempt to include the file directly
        $maybe = plugin_dir_path(__FILE__) . 'includes/Utility/valheim-weather.php';
        if (file_exists($maybe)) require_once($maybe);
    }

    if (!class_exists('\\Jotunheim\\Utility\\Yj')) {
        return new WP_Error('no_generator', 'Weather generator not available on server after include', array('status' => 500));
    }

    // Wind: ng(($tick + numericSeed) * 125, $ig)
    $ig = new \Jotunheim\Utility\Yj(0);
    if (!function_exists('\\Jotunheim\\Utility\\ng')) {
        return new WP_Error('no_generator_fn', 'Wind generator function missing after include', array('status' => 500));
    }
    $wind = \Jotunheim\Utility\ng(($tick + $numericSeed) * 125, $ig);

    // Weather: weatherSeed = floor((($tick + numericSeed) * 125) / 666); og(weatherSeed, $ig2)
    if (!function_exists('\\Jotunheim\\Utility\\og')) {
        return new WP_Error('no_generator_fn2', 'Weather generator function missing after include', array('status' => 500));
    }
    $ig2 = new \Jotunheim\Utility\Yj(0);
    $weatherSeed = intval(floor((($tick + $numericSeed) * 125) / 666));
    $weathers = \Jotunheim\Utility\og($weatherSeed, $ig2);

    $data = array(
        'day' => $day,
        'tick' => $tick,
        'numericSeed' => $numericSeed,
        'wind' => $wind,
        'weathers' => $weathers
    );

    return rest_ensure_response($data);
}
