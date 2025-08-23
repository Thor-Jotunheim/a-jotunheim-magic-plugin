// Node-friendly core of Valheim weather algorithm (extracted from assets/js/valheim-weather.js)
// Exports: GAME_DAY, WEATHER_PERIOD, WIND_PERIOD, ENV_STATES, ENV_SETUP, BIOMES, ValheimRandom, getWeathersAt, getGlobalWind

// Valheim time constants
var GAME_DAY = 1800; // seconds
var WEATHER_PERIOD = 666;
var WIND_PERIOD = 125;
var INTRO_DURATION = 2040;

// Weather types
var ENV_STATES = {
    'Clear': { emoji: '☀️', name: 'Clear', wind: [0.0, 1.0] },
    'Heath_clear': { emoji: '☀️', name: 'Clear', wind: [0.0, 1.0] },
    'Twilight_Clear': { emoji: '🌕', name: 'Clear', wind: [0.0, 1.0] },
    'Misty': { emoji: '☁️', name: 'Fog', wind: [0.0, 0.5] },
    'DeepForest_Mist': { emoji: '☀️', name: 'Clear', wind: [0.1, 0.6] },
    'Rain': { emoji: '🌧️', name: 'Rain', wind: [0.2, 0.8] },
    'LightRain': { emoji: '🌦️', name: 'Light Rain', wind: [0.1, 0.6] },
    'ThunderStorm': { emoji: '⛈️', name: 'Thunderstorm', wind: [0.8, 1.0] },
    'SwampRain': { emoji: '🌧️', name: 'Heavy Rain', wind: [0.2, 0.8] },
    'Snow': { emoji: '🌨️', name: 'Snow', wind: [0.3, 0.8] },
    'Twilight_Snow': { emoji: '🌨️', name: 'Snow', wind: [0.3, 0.8] },
    'SnowStorm': { emoji: '❄️', name: 'Blizzard', wind: [0.7, 1.0] },
    'Twilight_SnowStorm': { emoji: '❄️', name: 'Blizzard', wind: [0.7, 1.0] },
    'Mistlands_clear': { emoji: '☀️', name: 'Clear', wind: [0.05, 0.2] },
    'Mistlands_rain': { emoji: '🌧️', name: 'Rain', wind: [0.05, 0.2] },
    'Mistlands_thunder': { emoji: '⛈️', name: 'Thunderstorm', wind: [0.5, 1.0] },
    'Ashlands_ashrain': { emoji: '☔', name: 'Ash Rain', wind: [0.4, 0.9] },
    'Ashlands_misty': { emoji: '☁️', name: 'Ash Fog', wind: [0.1, 0.3] },
    'Ashlands_CinderRain': { emoji: '🌋', name: 'Cinder Rain', wind: [0.6, 1.0] },
    'Ashlands_storm': { emoji: '🌪️', name: 'Ash Storm', wind: [0.8, 1.0] },
    'Ashrain': { emoji: '☔', name: 'Ash Rain', wind: [0.4, 0.9] }
};

var ENV_SETUP = {
    'Meadows': [['Clear', 25], ['Rain', 1], ['Misty', 1], ['ThunderStorm', 1], ['LightRain', 1]],
    'BlackForest': [['DeepForest_Mist', 20], ['Rain', 1], ['Misty', 1], ['ThunderStorm', 1]],
    'Swamp': [['SwampRain', 1]],
    'Mountain': [['SnowStorm', 1], ['Snow', 5]],
    'Plains': [['Heath_clear', 5], ['Misty', 1], ['LightRain', 1]],
    'Ocean': [['Rain', 1], ['LightRain', 1], ['Misty', 1], ['Clear', 10], ['ThunderStorm', 1]],
    'Mistlands': [['Mistlands_clear', 15], ['Mistlands_rain', 1], ['Mistlands_thunder', 1]],
    'Ashlands': [['Ashlands_ashrain', 30], ['Ashlands_misty', 2], ['Ashlands_CinderRain', 4], ['Ashlands_storm', 1]]
};

var BIOMES = {
    'Meadows': { name: 'Meadows', icon: '⛳' },
    'BlackForest': { name: 'Black Forest', icon: '🌳' },
    'Swamp': { name: 'Swamp', icon: '🐸' },
    'Ocean': { name: 'Ocean', icon: '🌊' },
    'Mountain': { name: 'Mountain', icon: '🏔️' },
    'Plains': { name: 'Plains', icon: '🌺' },
    'Mistlands': { name: 'Mistlands', icon: '☁️' },
    'Ashlands': { name: 'Ashlands', icon: '🔥' }
};

function ValheimRandom(seed) {
    this.state = this.init(seed);
}

ValheimRandom.prototype.init = function(e) {
    var t = e >>> 0;
    var r = Math.imul(t, 1812433253) + 1 >>> 0;
    var i = Math.imul(r, 1812433253) + 1 >>> 0;
    var a = Math.imul(i, 1812433253) + 1 >>> 0;
    this.state = { a: t, b: r, c: i, d: a };
    return this.state;
};

ValheimRandom.prototype.next = function() {
    var e = this.state.a ^ (this.state.a << 11);
    this.state.a = this.state.b;
    this.state.b = this.state.c;
    this.state.c = this.state.d;
    this.state.d = this.state.d ^ (this.state.d >>> 19) ^ e ^ (e >>> 8);
    return this.state.d;
};

ValheimRandom.prototype.random = function() {
    return ((this.next() << 9) >>> 0) / 4294966784;
};

ValheimRandom.prototype.rangeFloat = function(min, max) { return max - this.random() * (max - min); };

ValheimRandom.prototype.rangeInt = function(min, max) { return min + (this.next() >>> 0) % (max - min); };

ValheimRandom.prototype.insideUnitCircle = function() {
    var e = this.rangeFloat(0, 2 * Math.PI);
    var t = Math.sqrt(this.rangeFloat(0, 1));
    return { x: Math.cos(e) * t, y: Math.sin(e) * t };
};

var random = new ValheimRandom(0);

function lerp(a, b, t) { return a + (b - a) * t; }
function clamp01(v) { return Math.max(0, Math.min(1, v)); }

function rollWeather(weathers, roll) {
    var totalWeight = weathers.reduce(function(sum, weather) { return sum + weather[1]; }, 0);
    var randomWeight = totalWeight * roll;
    var sum = 0;
    for (var i = 0; i < weathers.length; i++) {
        sum += weathers[i][1];
        if (randomWeight < sum) return weathers[i][0];
    }
    return weathers[weathers.length - 1][0];
}

function getWeathersAt(windTick) {
    var weatherSeed = Math.floor((windTick * WIND_PERIOD) / WEATHER_PERIOD);
    random.init(weatherSeed);
    var rng = random.rangeFloat(0, 1);

    var day984StartTime = 984 * GAME_DAY;
    var day984StartIndex = Math.floor(day984StartTime / WEATHER_PERIOD);
    var weatherIndex = Math.floor((windTick * WIND_PERIOD) / WEATHER_PERIOD);
    if (weatherIndex >= day984StartIndex && weatherIndex <= day984StartIndex + 20) {
        // keep debug friendly for node runs
        console.log('Day 984 Debug - Weather index', weatherIndex, 'RNG:', rng.toFixed(4));
    }

    return Object.keys(BIOMES).map(function(biome) {
        var biomeWeathers = ENV_SETUP[biome] || ENV_SETUP['Meadows'];
        var weather = rollWeather(biomeWeathers, rng);
        if (weatherIndex >= day984StartIndex && weatherIndex <= day984StartIndex + 20) {
            console.log('  ', biome + ':', weather);
        }
        return weather;
    });
}

function getGlobalWind(windTick) {
    var wind = { angle: 0, intensity: 0.5 };

    function addOctave(windTick, octave) {
        var period = Math.floor(windTick / (8 / octave));
        random.init(period);
        wind.angle += random.random() * 2 * Math.PI / octave;
        wind.intensity += (random.random() - 0.5) / octave;
    }

    addOctave(windTick, 1);
    addOctave(windTick, 2);
    addOctave(windTick, 4);
    addOctave(windTick, 8);

    wind.intensity = clamp01(wind.intensity);
    wind.angle = (wind.angle * 180 / Math.PI) % 360;
    if (wind.angle < 0) wind.angle += 360;
    return wind;
}

module.exports = {
    GAME_DAY, WEATHER_PERIOD, WIND_PERIOD, ENV_STATES, ENV_SETUP, BIOMES, ValheimRandom, getWeathersAt, getGlobalWind
};
