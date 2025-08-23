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

    register_rest_route('jotunheim/v1', '/weather-range', array(
        'methods' => 'GET',
        'callback' => 'jotunheim_weather_range_handler',
        'args' => array(
            'from' => array('required' => false, 'default' => 1, 'sanitize_callback' => 'absint'),
            'to' => array('required' => false, 'default' => 1, 'sanitize_callback' => 'absint'),
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

    // Determine numeric seed only if admin provided an override; default behavior is seed-agnostic
    $numericSeed = 0;
    $seed_used_label = '';
    if ($seedParam && current_user_can('manage_options')) {
        $numericSeed = jotunheim_get_numeric_seed_from_string($seedParam);
        $seed_used_label = '_' . md5($seedParam);
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

    // Transient caching for single-day requests
    // include seed label in cache key only if an admin override was used
    $cache_key = 'jhm_weather_' . md5($day . $seed_used_label);
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return rest_ensure_response($cached);
    }

    // Wind: follow kirilloid/Valheim — depends on tick/time only. If admin provided seed override,
    // apply it by offsetting the tick multiplication (explicit opt-in).
    $ig = new \Jotunheim\Utility\Yj(0);
    if (!function_exists('\\Jotunheim\\Utility\\ng')) {
        return new WP_Error('no_generator_fn', 'Wind generator function missing after include', array('status' => 500));
    }
    $windTickSeed = $tick * 125;
    if ($numericSeed !== 0) {
        $windTickSeed = ($tick + $numericSeed) * 125;
    }
    $wind = \Jotunheim\Utility\ng($windTickSeed, $ig);

    // Weather: weatherSeed = floor((($tick + numericSeed) * 125) / 666); og(weatherSeed, $ig2)
    if (!function_exists('\\Jotunheim\\Utility\\og')) {
        return new WP_Error('no_generator_fn2', 'Weather generator function missing after include', array('status' => 500));
    }
    $ig2 = new \Jotunheim\Utility\Yj(0);
    $weatherSeedBase = ($tick * 125);
    if ($numericSeed !== 0) {
        $weatherSeedBase = (($tick + $numericSeed) * 125);
    }
    $weatherSeed = intval(floor($weatherSeedBase / 666));
    $weathers = \Jotunheim\Utility\og($weatherSeed, $ig2);

    $data = array(
        'day' => $day,
        'tick' => $tick,
        'wind' => $wind,
        'weathers' => $weathers
    );

    // Store in transient for 1 hour to speed repeated calls
    set_transient($cache_key, $data, HOUR_IN_SECONDS);

    return rest_ensure_response($data);
}

function jotunheim_weather_range_handler($request) {
    // Support either 'day' (alias) or 'from'/'to' range
    if (isset($request['day'])) {
        $from = $to = max(1, intval($request['day']));
    } else {
        $from = isset($request['from']) ? max(1, intval($request['from'])) : 1;
        $to = isset($request['to']) ? max(1, intval($request['to'])) : $from;
    }
    if ($to < $from) { $tmp = $from; $from = $to; $to = $tmp; }
    // cap range to prevent heavy work
    $maxRange = 200; // reasonable safety limit
    if (($to - $from) > $maxRange) {
        $to = $from + $maxRange;
    }

    $seedParam = isset($request['seed']) ? $request['seed'] : '';
    $numericSeed = 0;
    $seed_used_label = '';
    if ($seedParam && current_user_can('manage_options')) {
        $numericSeed = jotunheim_get_numeric_seed_from_string($seedParam);
        $seed_used_label = '_' . md5($seedParam);
    }

    // Ensure generator code is loaded
    if (!class_exists('\Jotunheim\Utility\Yj') || !function_exists('\Jotunheim\Utility\og') || !function_exists('\Jotunheim\Utility\ng')) {
        $maybe = plugin_dir_path(__FILE__) . 'includes/Utility/valheim-weather.php';
        if (file_exists($maybe)) require_once($maybe);
    }
    if (!class_exists('\Jotunheim\Utility\Yj')) {
        return new WP_Error('no_generator', 'Weather generator not available on server after include', array('status' => 500));
    }

    // Transient caching for range responses (includes from/to and numericSeed in key)
    // include seed label in cache key only if an admin override was used
    $range_cache_key = 'jhm_weather_range_' . md5($from . '_' . $to . $seed_used_label);
    $range_cached = get_transient($range_cache_key);
    if ($range_cached !== false) {
        return rest_ensure_response($range_cached);
    }

    // Constants used by the algorithm
    $GAME_DAY = 1800;
    $WIND_PERIOD = 125;
    $WEATHER_PERIOD = 666;

    $indexed = array();

    for ($day = $from; $day <= $to; $day++) {
        $startTime = ($day - 1) * $GAME_DAY;
        $startTick = intval(floor($startTime / $WIND_PERIOD));
        $endTick = intval(floor((($day * $GAME_DAY) - 1) / $WIND_PERIOD));

        for ($windTick = $startTick; $windTick <= $endTick; $windTick++) {
            $tick = $windTick * $WIND_PERIOD;

            // compute wind and weather using tick/time only unless admin provided an explicit seed override
            $ig = new \Jotunheim\Utility\Yj(0);
            $windTickSeed = ($tick * $WIND_PERIOD);
            if ($numericSeed !== 0) {
                $windTickSeed = (($tick + $numericSeed) * $WIND_PERIOD);
            }
            $wind = \Jotunheim\Utility\ng($windTickSeed, $ig);

            // weather seed
            $ig2 = new \Jotunheim\Utility\Yj(0);
            $weatherSeedBase = ($tick * $WIND_PERIOD);
            if ($numericSeed !== 0) {
                $weatherSeedBase = (($tick + $numericSeed) * $WIND_PERIOD);
            }
            $weatherSeed = intval(floor($weatherSeedBase / $WEATHER_PERIOD));
            $weathers = \Jotunheim\Utility\og($weatherSeed, $ig2);

            $indexed[strval($windTick)] = array(
                'tick' => $tick,
                'day' => $day,
                'weathers' => $weathers,
                'wind' => $wind
            );
        }
    }

    $resp = array(
        'from' => $from,
        'to' => $to,
        'indexed' => $indexed
    );

    return rest_ensure_response($resp);
}
