const fs = require('fs');
const path = require('path');
const core = require(path.join(__dirname, 'valheim-weather'));

const { Yj, og, ng } = core;

const GAME_DAY = 1800;
const WIND_PERIOD = 125;
const WEATHER_PERIOD = 666;
const WIND_TICK_SHIFT = -6; // must match client/server shim

function getWeathersAt(windTick){
  const shifted = windTick + WIND_TICK_SHIFT;
  const weatherSeed = Math.floor((shifted * WIND_PERIOD) / WEATHER_PERIOD);
  const r = new Yj(0);
  return og(weatherSeed, r);
}

function getGlobalWind(windTick){
  const shifted = windTick + WIND_TICK_SHIFT;
  return ng(shifted * WIND_PERIOD, new Yj(0));
}

function loadLiveForDay(day){
  const candidate = path.join(__dirname, `..`, `tmp_live_weather_${day}.json`);
  if (!fs.existsSync(candidate)) return null;
  try { return JSON.parse(fs.readFileSync(candidate,'utf8')); } catch (e){ return null; }
}

function compareForDay(day){
  const live = loadLiveForDay(day);
  if (!live) return { day, found:false };
  const indexed = live.indexed || {};
  let total = 0, weaMatch = 0, windErr = 0;
  for (const key of Object.keys(indexed)){
    total++;
    const entry = indexed[key];
    const windTick = parseInt(key,10);
    const localWea = getWeathersAt(windTick);
    const localWind = getGlobalWind(windTick);
    const liveWea = entry.weathers || entry;
    // compare arrays
    let wm = 0;
    for (let i=0;i<Math.min(localWea.length, liveWea.length); i++) if (localWea[i]===liveWea[i]) wm++;
    weaMatch += wm;
    // wind error: angular difference + intensity scaled
    const da = Math.abs((localWind.angle - (entry.wind.angle||0)+540)%360-180);
    const di = Math.abs((localWind.intensity - (entry.wind.intensity||0)));
    windErr += da + di*100;
  }
  return { day, found:true, total, weaMatch, windErr };
}

async function run(){
  const start = parseInt(process.argv[2]||'1',10);
  const end = parseInt(process.argv[3]||'200',10);
  const results = [];
  for (let d=start; d<=end; d++){
    const r = compareForDay(d);
    if (r.found) results.push(r);
  }
  results.sort((a,b)=> (b.weaMatch/a.total) - (a.weaMatch/a.total) || a.windErr - b.windErr);
  console.log('Parity sweep summary (days with live snapshots):');
  for (const r of results) console.log(`day ${r.day}: matches ${r.weaMatch}/${r.total}, windErr ${r.windErr.toFixed(2)}`);
}

run();
