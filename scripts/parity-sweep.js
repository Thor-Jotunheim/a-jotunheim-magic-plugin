const path = require('path');
const core = require(path.join(__dirname, '..', 'lib', 'valheim-weather-core'));
const kir = require(path.join(__dirname, 'run-kirilloid-core'));

const { GAME_DAY, WEATHER_PERIOD, WIND_PERIOD, getWeathersAt, getGlobalWind } = core;
const { Yj, ng, og } = kir;

const results = [];
for (let i = 0; i < 30; i++) {
  const gameTime = (1 - 1) * GAME_DAY + i * WEATHER_PERIOD;
  const windTick = Math.floor(gameTime / WIND_PERIOD);

  // our core — compute wind first then weather to match kirilloid call order
  const ourWind = getGlobalWind(windTick);
  const ourWeathers = getWeathersAt(windTick);

  // kirilloid core
  const ig = new Yj(0);
  const kirWind = ng(windTick * WIND_PERIOD, ig);
  const weatherSeed = Math.floor((windTick * WIND_PERIOD) / WEATHER_PERIOD);
  const kirWeathers = og(weatherSeed, ig);

  results.push({
    idx: i,
    windTick,
    our: {
      angle: Math.round(ourWind.angle),
      intensityPct: Math.round(ourWind.intensity * 100),
      bf: ourWeathers[1]
    },
    kir: {
      angle: Math.round(kirWind.angle),
      intensityPct: Math.round(kirWind.intensity * 100),
      bf: kirWeathers[1]
    },
    match: Math.round(ourWind.angle) === Math.round(kirWind.angle) && Math.round(ourWind.intensity*100) === Math.round(kirWind.intensity*100) && ourWeathers[1] === kirWeathers[1]
  });
}

console.log(JSON.stringify(results, null, 2));
