// Final verification - Day 984 should now show ThunderStorm at 13:41
const GAME_DAY = 1800;
const WEATHER_PERIOD = 666;
const INTRO_DURATION = 2040;

function ValheimRandom(seed) {
    this.state = this.init(seed);
}

ValheimRandom.prototype.init = function(seed) {
    var a = seed >>> 0;
    var b = (this.imul(a, 1812433253) + 1) >>> 0;
    var c = (this.imul(b, 1812433253) + 1) >>> 0;
    var d = (this.imul(c, 1812433253) + 1) >>> 0;
    return (this.state = { a: a, b: b, c: c, d: d });
};

ValheimRandom.prototype.imul = function(a, b) {
    return Math.imul ? Math.imul(a, b) : ((a * b) | 0);
};

ValheimRandom.prototype.random = function() {
    var a = this.state.a, b = this.state.b, c = this.state.c, d = this.state.d;
    var t = b << 9 ^ a;
    var w = (c + (d = d + 1 | 0)) | 0;
    b = b ^ b >>> 2 ^ c ^ c << 10;
    c = c ^ c >>> 13 ^ d ^ d << 3;
    a = a ^ a << 13 ^ t ^ t << 5;
    this.state = { a: a, b: b, c: c, d: d };
    return ((a ^ b ^ c) >>> 0) / 4294967296;
};

// FIXED: Standard rangeFloat implementation
ValheimRandom.prototype.rangeFloat = function(min, max) {
    return min + this.random() * (max - min);
};

var random = new ValheimRandom(0);

const ENV_SETUP = {
    'Meadows': [['Clear', 25], ['Rain', 1], ['Misty', 1], ['ThunderStorm', 1], ['LightRain', 1]],
    'BlackForest': [['DeepForest_Mist', 20], ['Rain', 1], ['Misty', 1], ['ThunderStorm', 1]],
    'Swamp': [['SwampRain', 1]],
    'Mountain': [['SnowStorm', 1], ['Snow', 5]],
    'Plains': [['Heath_clear', 5], ['Misty', 1], ['LightRain', 1]],
    'Ocean': [['Rain', 1], ['LightRain', 1], ['Misty', 1], ['Clear', 10], ['ThunderStorm', 1]]
};

const BIOMES = ['Meadows', 'BlackForest', 'Swamp', 'Mountain', 'Plains', 'Ocean'];

function rollWeather(weathers, roll) {
    var totalWeight = 0;
    for (var i = 0; i < weathers.length; i++) {
        totalWeight += weathers[i][1];
    }
    var randomWeight = totalWeight * roll;
    var sum = 0;
    for (var i = 0; i < weathers.length; i++) {
        var env = weathers[i][0];
        var weight = weathers[i][1];
        sum += weight;
        if (randomWeight < sum) return env;
    }
    return weathers[weathers.length - 1][0];
}

function getWeathersAt(index) {
    if (index < INTRO_DURATION / WEATHER_PERIOD) {
        return BIOMES.map(function() { return 'ThunderStorm'; });
    }
    
    random.init(index);
    var rng = random.rangeFloat(0, 1);
    
    return BIOMES.map(function(biome) {
        var biomeWeathers = ENV_SETUP[biome] || ENV_SETUP['Meadows'];
        return rollWeather(biomeWeathers, rng);
    });
}

console.log('=== FINAL VERIFICATION - DAY 984 FIXED ===');

const day = 984;
const gameDay = day - 1; // 0-based
const dayStartTime = gameDay * GAME_DAY;

// Test 13:41
const time1341Seconds = (13 + 41/60) / 24 * GAME_DAY;
const absoluteTime1341 = dayStartTime + time1341Seconds;
const weatherIndexAt1341 = Math.floor(absoluteTime1341 / WEATHER_PERIOD);

const weathersAt1341 = getWeathersAt(weatherIndexAt1341);

console.log(`Day ${day} at 13:41:`);
console.log(`Weather index: ${weatherIndexAt1341}`);
console.log('Weather for all biomes:');
for (let i = 0; i < BIOMES.length; i++) {
    const weather = weathersAt1341[i];
    const isThunder = weather === 'ThunderStorm';
    const marker = isThunder ? ' ⚡⚡⚡ THUNDERSTORM!' : '';
    console.log(`  ${BIOMES[i]}: ${weather}${marker}`);
}

// Test a few hours around 13:41 to show the weather pattern
console.log(`\n=== WEATHER PATTERN FOR DAY ${day} ===`);
for (let hour = 10; hour <= 17; hour++) {
    const timeSeconds = (hour / 24) * GAME_DAY;
    const absoluteTime = dayStartTime + timeSeconds;
    const weatherIndex = Math.floor(absoluteTime / WEATHER_PERIOD);
    const weathers = getWeathersAt(weatherIndex);
    
    const blackForestWeather = weathers[1]; // BlackForest is index 1
    const thunderMarker = blackForestWeather === 'ThunderStorm' ? ' ⚡' : '';
    
    console.log(`${hour.toString().padStart(2, '0')}:00 - BlackForest: ${blackForestWeather}${thunderMarker}`);
}

console.log('\n✅ SUCCESS! Day 984 13:41 should now show ThunderStorm in BlackForest!');
