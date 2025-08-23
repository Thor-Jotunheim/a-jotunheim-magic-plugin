<?php
require __DIR__ . '/../includes/Utility/valheim-weather.php';

echo "Testing valheim-weather PHP port\n";
$seeds = [1,2,100,1000,12345];
foreach ($seeds as $s) {
    $wind = getGlobalWind($s);
    $weathers = getWeathersAt($s);
    echo "Seed: $s\n";
    echo "  Wind angle: " . round($wind['angle']) . " intensity: " . round($wind['intensity']*100) . "%\n";
    echo "  Biome weather sample: " . ($weathers[1] ?? 'null') . "\n";
}

echo "Done.\n";
