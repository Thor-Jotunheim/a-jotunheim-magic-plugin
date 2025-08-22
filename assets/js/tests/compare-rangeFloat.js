// Compare old vs new rangeFloat implementations
const GAME_DAY = 1800;
const WEATHER_PERIOD = 666;
const INTRO_DURATION = 2040;

// Unity-compatible random number generator with OLD rangeFloat
function OldValheimRandom(seed) {
    this.state = this.init(seed);
}

OldValheimRandom.prototype.init = function(seed) {
    var a = seed >>> 0;
    var b = (this.imul(a, 1812433253) + 1) >>> 0;
    var c = (this.imul(b, 1812433253) + 1) >>> 0;
    var d = (this.imul(c, 1812433253) + 1) >>> 0;
    return (this.state = { a: a, b: b, c: c, d: d });
};

OldValheimRandom.prototype.imul = function(a, b) {
    return Math.imul ? Math.imul(a, b) : ((a * b) | 0);
};

OldValheimRandom.prototype.random = function() {
    var a = this.state.a, b = this.state.b, c = this.state.c, d = this.state.d;
    var t = b << 9 ^ a;
    var w = (c + (d = d + 1 | 0)) | 0;
    b = b ^ b >>> 2 ^ c ^ c << 10;
    c = c ^ c >>> 13 ^ d ^ d << 3;
    a = a ^ a << 13 ^ t ^ t << 5;
    this.state = { a: a, b: b, c: c, d: d };
    return ((a ^ b ^ c) >>> 0) / 4294967296;
};

// OLD rangeFloat (your original implementation)
OldValheimRandom.prototype.rangeFloat = function(min, max) {
    return min + this.random() * (max - min);
};

// NEW Unity-compatible random number generator with CORRECTED rangeFloat
function NewValheimRandom(seed) {
    this.state = this.init(seed);
}

NewValheimRandom.prototype.init = function(seed) {
    var a = seed >>> 0;
    var b = (this.imul(a, 1812433253) + 1) >>> 0;
    var c = (this.imul(b, 1812433253) + 1) >>> 0;
    var d = (this.imul(c, 1812433253) + 1) >>> 0;
    return (this.state = { a: a, b: b, c: c, d: d });
};

NewValheimRandom.prototype.imul = function(a, b) {
    return Math.imul ? Math.imul(a, b) : ((a * b) | 0);
};

NewValheimRandom.prototype.random = function() {
    var a = this.state.a, b = this.state.b, c = this.state.c, d = this.state.d;
    var t = b << 9 ^ a;
    var w = (c + (d = d + 1 | 0)) | 0;
    b = b ^ b >>> 2 ^ c ^ c << 10;
    c = c ^ c >>> 13 ^ d ^ d << 3;
    a = a ^ a << 13 ^ t ^ t << 5;
    this.state = { a: a, b: b, c: c, d: d };
    return ((a ^ b ^ c) >>> 0) / 4294967296;
};

// NEW rangeFloat (kirilloid authentic)
NewValheimRandom.prototype.rangeFloat = function(min, max) {
    return max - this.random() * (max - min);
};

var oldRandom = new OldValheimRandom(0);
var newRandom = new NewValheimRandom(0);

const ENV_SETUP = {
    'Meadows': [['Clear', 25], ['Rain', 1], ['Misty', 1], ['ThunderStorm', 1], ['LightRain', 1]]
};

function rollWeather(weathers, roll, label) {
    var totalWeight = 0;
    for (var i = 0; i < weathers.length; i++) {
        totalWeight += weathers[i][1];
    }
    var randomWeight = totalWeight * roll;
    var sum = 0;
    console.log(`    ${label} roll=${roll.toFixed(4)}, totalWeight=${totalWeight}, randomWeight=${randomWeight.toFixed(4)}`);
    for (var i = 0; i < weathers.length; i++) {
        var env = weathers[i][0];
        var weight = weathers[i][1];
        sum += weight;
        console.log(`      ${env} (weight=${weight}): sum=${sum}, check: ${randomWeight.toFixed(4)} < ${sum} = ${randomWeight < sum}`);
        if (randomWeight < sum) return env;
    }
    return weathers[weathers.length - 1][0];
}

console.log('=== COMPARING OLD vs NEW RANGEFLOTA FOR WEATHER INDEX 2658 ===');

const weatherIndex = 2658;
console.log(`Weather Index ${weatherIndex} (Day 984 at 11:02-19:55, includes 13:41):\n`);

// Test old implementation
console.log('OLD rangeFloat (min + random * range):');
oldRandom.init(weatherIndex);
var oldRng = oldRandom.rangeFloat(0, 1);
console.log('  RNG value:', oldRng.toFixed(6));
var oldWeather = rollWeather(ENV_SETUP['Meadows'], oldRng, 'OLD');
console.log('  Result:', oldWeather);
console.log('');

// Test new implementation  
console.log('NEW rangeFloat (max - random * range):');
newRandom.init(weatherIndex);
var newRng = newRandom.rangeFloat(0, 1);
console.log('  RNG value:', newRng.toFixed(6));
var newWeather = rollWeather(ENV_SETUP['Meadows'], newRng, 'NEW');
console.log('  Result:', newWeather);
