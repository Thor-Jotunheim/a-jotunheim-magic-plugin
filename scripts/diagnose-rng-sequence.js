const path = require('path');
const core = require(path.join(__dirname, '..', 'lib', 'valheim-weather-core'));
const kir = require(path.join(__dirname, 'run-kirilloid-core'));

const { GAME_DAY, WEATHER_PERIOD, WIND_PERIOD, getWeathersAt, getGlobalWind, ValheimRandom } = core;
const { Yj, ng, og } = kir;

function traceOur(windTick) {
  const trace = [];
  const vr = new ValheimRandom(0);

  // instrument ValheimRandom methods
  const originalInit = vr.init;
  vr.init = function(s) { trace.push({ who: 'our', action: 'init', seed: s }); return originalInit.call(this, s); };
  const originalRandom = vr.random;
  vr.random = function() { const v = originalRandom.call(this); trace.push({ who: 'our', action: 'random', value: v }); return v; };

  // local implementations of rollWeather/getWeathersAt/getGlobalWind that use our instrumented vr
  function rollWeatherLocal(weathers, roll) {
    var totalWeight = weathers.reduce(function(sum, weather) { return sum + weather[1]; }, 0);
    var randomWeight = totalWeight * roll;
    var sum = 0;
    for (var i = 0; i < weathers.length; i++) {
        sum += weathers[i][1];
        if (randomWeight < sum) return weathers[i][0];
    }
    return weathers[weathers.length - 1][0];
  }

  const { WIND_PERIOD: WP, WEATHER_PERIOD: WEP, GAME_DAY: GD, ENV_SETUP, BIOMES, INTRO_DURATION } = require(path.join(__dirname, '..', 'lib', 'valheim-weather-core'));

  function our_getWeathersAt(windTick) {
    if (windTick * WP < INTRO_DURATION) return Object.keys(BIOMES).map(function(){ return 'ThunderStorm'; });
    var weatherSeed = Math.floor((windTick * WP) / WEP);
    vr.init(weatherSeed);
    var rng = vr.rangeFloat(0,1);
    return Object.keys(BIOMES).map(function(biome) { var biomeWeathers = ENV_SETUP[biome] || ENV_SETUP['Meadows']; return rollWeatherLocal(biomeWeathers, rng); });
  }

  function our_getGlobalWind(windTick) {
    var wind = { angle: 0, intensity: 0.5 };
    function addOctave(windTick, octave) {
      var period = Math.floor(windTick / (8 / octave));
      vr.init(period);
      wind.angle += vr.random() * 2 * Math.PI / octave;
      wind.intensity += (vr.random() - 0.5) / octave;
    }
    addOctave(windTick, 1);
    addOctave(windTick, 2);
    addOctave(windTick, 4);
    addOctave(windTick, 8);
    wind.intensity = Math.max(0, Math.min(1, wind.intensity));
    wind.angle = (wind.angle * 180 / Math.PI) % 360;
    if (wind.angle < 0) wind.angle += 360;
    return wind;
  }

  const weathers = our_getWeathersAt(windTick);
  const wind = our_getGlobalWind(windTick);
  return { trace, weathers, wind };
}

function traceKir(windTick) {
  const trace = [];
  const ig = new Yj(0);

  // wrap init
  const origInit = ig.init;
  ig.init = function(s) { trace.push({ who: 'kir', action: 'init', seed: s }); return origInit.call(this, s); };

  // wrap next and random
  const origNext = ig.next;
  ig.next = function() { const v = origNext.call(this); trace.push({ who: 'kir', action: 'next', value: v >>> 0 }); return v; };
  const origRandom = ig.random;
  ig.random = function() { const v = origRandom.call(this); trace.push({ who: 'kir', action: 'random', value: v }); return v; };

  // call ng and og using the instrumented ig
  const wind = ng(windTick * WIND_PERIOD, ig);
  const weatherSeed = Math.floor((windTick * WIND_PERIOD) / WEATHER_PERIOD);
  const weathers = og(weatherSeed, ig);

  return { trace, weathers, wind };
}

if (require.main === module) {
  const windTick = 6; // Day1 11:00 sample
  console.log('Tracing our core for windTick', windTick);
  const our = traceOur(windTick);
  console.log(JSON.stringify(our.trace, null, 2));
  console.log('Our wind:', Math.round(our.wind.angle), Math.round(our.wind.intensity*100));
  console.log('Our BF:', our.weathers[1]);

  console.log('\nTracing kirilloid core for windTick', windTick);
  const kir = traceKir(windTick);
  console.log(JSON.stringify(kir.trace, null, 2));
  console.log('Kir wind:', Math.round(kir.wind.angle), Math.round(kir.wind.intensity*100));
  console.log('Kir BF:', kir.weathers[1]);
}

module.exports = { traceOur, traceKir };
