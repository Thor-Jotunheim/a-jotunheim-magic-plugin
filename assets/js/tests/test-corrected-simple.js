// Node.js compatible test for corrected weather algorithm
const GAME_DAY = 1800;
const WEATHER_PERIOD = 666;
const INTRO_DURATION = 2040;

// Unity-compatible random number generator with CORRECTED rangeFloat
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

// CORRECTED rangeFloat implementation (authentic kirilloid)
ValheimRandom.prototype.rangeFloat = function(min, max) {
    // Unity uses 1.0 - value for some reason (authentic kirilloid implementation)
    return max - this.random() * (max - min);
};

var random = new ValheimRandom(0);

// Weather setups for each biome
const ENV_SETUP = {
    'Meadows': [['Clear', 25], ['Rain', 1], ['Misty', 1], ['ThunderStorm', 1], ['LightRain', 1]],
    'BlackForest': [['DeepForest_Mist', 20], ['Rain', 1], ['Misty', 1], ['ThunderStorm', 1]],
    'Swamp': [['SwampRain', 1]],
    'Mountain': [['SnowStorm', 1], ['Snow', 5]],
    'Plains': [['Heath_clear', 5], ['Misty', 1], ['LightRain', 1]],
    'Ocean': [['Rain', 1], ['LightRain', 1], ['Misty', 1], ['Clear', 10], ['ThunderStorm', 1]]
};

const BIOMES = {
    'Meadows': true,
    'BlackForest': true, 
    'Swamp': true,
    'Mountain': true,
    'Plains': true,
    'Ocean': true
};

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
        return Object.keys(BIOMES).map(function() { return 'ThunderStorm'; });
    }
    
    random.init(index);
    var rng = random.rangeFloat(0, 1);
    
    return Object.keys(BIOMES).map(function(biome) {
        var biomeWeathers = ENV_SETUP[biome] || ENV_SETUP['Meadows'];
        return rollWeather(biomeWeathers, rng);
    });
}

console.log('=== TESTING CORRECTED RANGEFLOTA IMPLEMENTATION ===');
console.log('Testing Day 984 with authentic kirilloid rangeFloat...\n');

// Test the weather for Day 984
const day = 984;
const gameDay = day - 1; // 983
const dayStartTime = gameDay * GAME_DAY; // 1769400

console.log('Day 984 weather periods:');
console.log('GAME_DAY =', GAME_DAY, 'seconds');
console.log('WEATHER_PERIOD =', WEATHER_PERIOD, 'seconds');
console.log('Day start time:', dayStartTime, 'seconds\n');

// Find weather changes that affect Day 984
const dayStartIndex = Math.floor(dayStartTime / WEATHER_PERIOD);
const dayEndTime = dayStartTime + GAME_DAY;
const dayEndIndex = Math.floor(dayEndTime / WEATHER_PERIOD);

console.log('Weather changes affecting Day 984:');
for (let weatherIndex = dayStartIndex; weatherIndex <= dayEndIndex; weatherIndex++) {
    const weatherStartTime = weatherIndex * WEATHER_PERIOD;
    const weatherEndTime = (weatherIndex + 1) * WEATHER_PERIOD;
    
    // Check if this weather period overlaps with Day 984
    if (weatherStartTime < dayEndTime && weatherEndTime > dayStartTime) {
        const effectiveStart = Math.max(weatherStartTime, dayStartTime);
        const effectiveEnd = Math.min(weatherEndTime, dayEndTime);
        
        // Convert to time within the day
        const startTimeInDay = effectiveStart - dayStartTime;
        const endTimeInDay = effectiveEnd - dayStartTime;
        
        // Convert to hours:minutes
        const startHour = Math.floor((startTimeInDay / GAME_DAY) * 24);
        const startMinute = Math.floor(((startTimeInDay / GAME_DAY) * 24 % 1) * 60);
        const endHour = Math.floor((endTimeInDay / GAME_DAY) * 24);
        const endMinute = Math.floor(((endTimeInDay / GAME_DAY) * 24 % 1) * 60);
        
        const startTimeStr = String(startHour).padStart(2, '0') + ':' + String(startMinute).padStart(2, '0');
        const endTimeStr = String(endHour).padStart(2, '0') + ':' + String(endMinute).padStart(2, '0');
        
        const weathers = getWeathersAt(weatherIndex);
        
        console.log(`Weather Index ${weatherIndex}: ${startTimeStr} - ${endTimeStr}`);
        console.log('  Meadows:', weathers[0]);
        console.log('  BlackForest:', weathers[1]);
        console.log('  Swamp:', weathers[2]);
        console.log('  Mountain:', weathers[3]);
        console.log('  Plains:', weathers[4]);
        console.log('  Ocean:', weathers[5]);
        
        // Check for thunderstorm around 13:41
        if ((startHour <= 13 && endHour >= 13) || (startHour <= 14 && endHour >= 13)) {
            console.log('  *** This period includes/overlaps 13:41 time range ***');
            if (weathers.includes('ThunderStorm')) {
                console.log('  *** THUNDERSTORM FOUND! ***');
            }
        }
        console.log('');
    }
}

// Check specific time 13:41
console.log('=== SPECIFIC TIME CHECK: 13:41 ===');
const time1341Seconds = (13 + 41/60) / 24 * GAME_DAY;
const absoluteTime1341 = dayStartTime + time1341Seconds;
const weatherIndexAt1341 = Math.floor(absoluteTime1341 / WEATHER_PERIOD);
const weathersAt1341 = getWeathersAt(weatherIndexAt1341);

console.log('Time 13:41 is at weather index:', weatherIndexAt1341);
console.log('Weather at 13:41:', weathersAt1341);
if (weathersAt1341.includes('ThunderStorm')) {
    console.log('*** THUNDERSTORM AT 13:41 CONFIRMED! ***');
}
