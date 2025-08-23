const path = require('path');
const core = require(path.join(__dirname, '..', 'lib', 'valheim-weather-core'));
const { GAME_DAY, WEATHER_PERIOD, WIND_PERIOD, getWeathersAt, getGlobalWind } = core;

function inspectAtDay(day, displayHours) {
    const gameDay = day - 1;
    const startTime = gameDay * GAME_DAY;
    displayHours.forEach(h => {
        const gameTime = startTime + h * (GAME_DAY / 24);
        const windTick = Math.floor(gameTime / WIND_PERIOD);
        const weathers = getWeathersAt(windTick);
        const wind = getGlobalWind(windTick);
        console.log(`Hour ${h}: gameTime=${gameTime}, windTick=${windTick}, windAngle=${Math.round(wind.angle)}, windInt=${Math.round(wind.intensity*100)}%, BF=${weathers[1]}`);
    });
}

console.log('Testing Day 1 around 11:00 and 13:00');
inspectAtDay(1, [11, 13]);

console.log('Testing a sequence of ticks around the day start:');
for (let offset = 0; offset < 6; offset++) {
    const gameTime = (1-1)*GAME_DAY + offset * 600; // 600s steps
    const windTick = Math.floor(gameTime / WIND_PERIOD);
    const weathers = getWeathersAt(windTick);
    const wind = getGlobalWind(windTick);
    console.log(`step ${offset}: gameTime=${gameTime}, windTick=${windTick}, wind=${Math.round(wind.angle)}deg ${Math.round(wind.intensity*100)}%, BF=${weathers[1]}`);
}

// Broad parity check across a small range and collect mismatches if any
console.log('\nRunning broader parity check (day 1, first 30 WEATHER_PERIOD indices)');
for (let i = 0; i < 30; i++) {
    const gameTime = (1-1)*GAME_DAY + i * WEATHER_PERIOD;
    const windTick = Math.floor(gameTime / WIND_PERIOD);
    const weathers = getWeathersAt(windTick);
    const wind = getGlobalWind(windTick);
    console.log(`idx ${i}: windTick=${windTick}, angle=${Math.round(wind.angle)}, int=${Math.round(wind.intensity*100)}%, BF=${weathers[1]}`);
}
