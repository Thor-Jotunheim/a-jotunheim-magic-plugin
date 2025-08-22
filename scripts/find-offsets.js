// Brute-force search for epoch/seed conventions that yield ThunderStorm in BlackForest at Day 984 13:41
const GAME_DAY = 1800;
const WEATHER_PERIOD = 666;
const TARGET_DAY = 984;
const TARGET_TIME_MINS = 13*60 + 41; // 13:41
const TARGET_GAME_TIME = (TARGET_DAY - 1) * GAME_DAY + TARGET_TIME_MINS * 60;

// ENV_SETUP BlackForest (kirilloid weights)
const ENV_SETUP = {
    'BlackForest': [['DeepForest_Mist', 20], ['Rain', 1], ['Misty', 1], ['ThunderStorm', 1]]
};

function rollWeather(weathers, roll) {
    const totalWeight = weathers.reduce((s,w)=>s+w[1],0);
    let randomWeight = totalWeight * roll;
    let sum = 0;
    for (let i=0;i<weathers.length;i++){
        sum += weathers[i][1];
        if (randomWeight < sum) return weathers[i][0];
    }
    return weathers[weathers.length-1][0];
}

// ValheimRandom implementation (same as in plugin)
function ValheimRandom(seed){ this.init(seed); }
ValheimRandom.prototype.imul = function(a,b){ return Math.imul ? Math.imul(a,b) : ((a*b)|0); };
ValheimRandom.prototype.init = function(seed){
    var a = seed >>> 0;
    var b = (this.imul(a, 1812433253) + 1) >>> 0;
    var c = (this.imul(b, 1812433253) + 1) >>> 0;
    var d = (this.imul(c, 1812433253) + 1) >>> 0;
    this.state = {a:a,b:b,c:c,d:d};
};
ValheimRandom.prototype.random = function(){
    var a=this.state.a,b=this.state.b,c=this.state.c,d=this.state.d;
    var t = (b << 9) ^ a;
    var w = (c + (d = (d + 1) | 0)) | 0;
    b = b ^ (b >>> 2) ^ c ^ (c << 10);
    c = c ^ (c >>> 13) ^ d ^ (d << 3);
    a = a ^ (a << 13) ^ t ^ (t << 5);
    this.state = {a:a,b:b,c:c,d:d};
    return ((a ^ b ^ c) >>> 0) / 4294967296;
};
ValheimRandom.prototype.rangeFloat = function(min,max){ return min + this.random() * (max - min); };

const random = new ValheimRandom(0);

// We'll test multiple seed formulas and record matches
const matches = [];
const step = 60; // seconds
// shifts to simulate accidental off-by-N index differences
const SHIFT_MIN = -100, SHIFT_MAX = 100;

for (let offset = 0; offset < 24*3600; offset += step) {
    for (let shift = SHIFT_MIN; shift <= SHIFT_MAX; shift++) {
        // Formula A: idx = floor((gameTime - offset) / WEATHER_PERIOD) + shift
        let idxA = Math.floor((TARGET_GAME_TIME - offset) / WEATHER_PERIOD) + shift;
        random.init(idxA >>> 0);
        let rngA = random.rangeFloat(0,1);
        if (rollWeather(ENV_SETUP['BlackForest'], rngA) === 'ThunderStorm') {
            matches.push({formula:'gameTime - offset', offset, shift, idx:idxA, rng:rngA});
            break; // stop shifts for this offset
        }

        // Formula B: idx = floor((gameTime + offset) / WEATHER_PERIOD) + shift
        let idxB = Math.floor((TARGET_GAME_TIME + offset) / WEATHER_PERIOD) + shift;
        random.init(idxB >>> 0);
        let rngB = random.rangeFloat(0,1);
        if (rollWeather(ENV_SETUP['BlackForest'], rngB) === 'ThunderStorm') {
            matches.push({formula:'gameTime + offset', offset, shift, idx:idxB, rng:rngB});
            break;
        }

        // Formula C: idx = floor(gameTime / WEATHER_PERIOD) + offsetShift (offset treated as seconds->index shift)
        let offsetShift = Math.round(offset / WEATHER_PERIOD);
        let idxC = Math.floor(TARGET_GAME_TIME / WEATHER_PERIOD) + offsetShift + shift;
        random.init(idxC >>> 0);
        let rngC = random.rangeFloat(0,1);
        if (rollWeather(ENV_SETUP['BlackForest'], rngC) === 'ThunderStorm') {
            matches.push({formula:'floor(gameTime/WEATHER_PERIOD)+offsetShift', offset, shift, idx:idxC, rng:rngC});
            break;
        }
    }
}

if (matches.length === 0) {
    console.log('No matches found in offset 0..24h with step',step);
} else {
    console.log('Found matches (showing first 40):');
    for (let i=0;i<Math.min(matches.length,40);i++){
        const m = matches[i];
        console.log(`${i+1}) formula=${m.formula} offset=${m.offset}s (${(m.offset/3600).toFixed(3)}h) shift=${m.shift} idx=${m.idx} rng=${m.rng.toFixed(6)}`);
    }
    console.log('Total matches:', matches.length);
}
