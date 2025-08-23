const fs = require('fs');
const path = require('path');
const core = require(path.join(__dirname, 'valheim-weather'));
const { Yj, og, ng } = core;

const GAME_DAY = 1800;
const WIND_PERIOD = 125;
const WEATHER_PERIOD = 666;

function getWeathersAt(windTick, shift){
  const shifted = windTick + shift;
  const weatherSeed = Math.floor((shifted * WIND_PERIOD) / WEATHER_PERIOD);
  const r = new Yj(0);
  return og(weatherSeed, r);
}

function getGlobalWind(windTick, shift){
  const shifted = windTick + shift;
  return ng(shifted * WIND_PERIOD, new Yj(0));
}

function loadLiveForDay(day){
  const candidate = path.join(__dirname, `..`, `tmp_live_weather_${day}.json`);
  if (!fs.existsSync(candidate)) return null;
  try { return JSON.parse(fs.readFileSync(candidate,'utf8')); } catch (e){ return null; }
}

function compareForDayWithShift(day, shift){
  const live = loadLiveForDay(day);
  if (!live) return { day, found:false };
  const indexed = live.indexed || {};
  let rows = 0, weaMatch = 0, windErr = 0;
  const perTick = {};
  for (const key of Object.keys(indexed)){
    rows++;
    const entry = indexed[key];
    const windTick = parseInt(key,10);
    const localWea = getWeathersAt(windTick, shift);
    const localWind = getGlobalWind(windTick, shift);
    const liveWea = entry.weathers || entry;
    let wm = 0;
    for (let i=0;i<Math.min(localWea.length, liveWea.length); i++) if (localWea[i]===liveWea[i]) wm++;
    weaMatch += wm;
    const da = Math.abs((localWind.angle - (entry.wind.angle||0)+540)%360-180);
    const di = Math.abs((localWind.intensity - (entry.wind.intensity||0)));
    const tickErr = da + di*100;
    windErr += tickErr;
    perTick[key] = { wm, tickErr };
  }
  const totalPossible = rows * 9;
  return { day, found:true, rows, weaMatch, totalPossible, pct: weaMatch/totalPossible, windErr, perTick };
}

function run(){
  const day = parseInt(process.argv[2]||'984',10);
  const min = parseInt(process.argv[3]||'-10',10);
  const max = parseInt(process.argv[4]||'10',10);
  const results = [];
  for (let shift = min; shift<=max; shift++){
    const r = compareForDayWithShift(day, shift);
    if (r.found) results.push({ shift, rows: r.rows, weaMatch: r.weaMatch, totalPossible: r.totalPossible, pct: r.pct, windErr: r.windErr });
  }
  results.sort((a,b)=> b.pct - a.pct || a.windErr - b.windErr);
  console.log('Shift sweep results (sorted best -> worst):');
  for (const r of results){
    console.log(`shift ${r.shift}: matches ${r.weaMatch}/${r.totalPossible} (${(r.pct*100).toFixed(2)}%), windErr ${r.windErr.toFixed(2)}`);
  }
}

run();
