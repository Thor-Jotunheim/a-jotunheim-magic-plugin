// Quick test for weather period helper functions
const GAME_DAY = 1800;
const WEATHER_PERIOD = 666;
const EPOCH_OFFSET = 2 * 3600 + 26 * 60; // 8760

function getWeatherPeriodIndex(gameTime) {
    return Math.floor((gameTime - EPOCH_OFFSET) / WEATHER_PERIOD);
}
function getGameTimeForWeatherIndex(index) {
    return index * WEATHER_PERIOD + EPOCH_OFFSET;
}
function getWeatherIndexRangeForDay(dayStartTime) {
    var first = Math.ceil((dayStartTime - EPOCH_OFFSET) / WEATHER_PERIOD);
    var last = Math.floor((dayStartTime + GAME_DAY - 1 - EPOCH_OFFSET) / WEATHER_PERIOD);
    if (first > last) {
        first = Math.floor((dayStartTime - EPOCH_OFFSET) / WEATHER_PERIOD);
        last = first;
    }
    return { first: first, last: last };
}

const targetDay = 984;
const targetMins = 13 * 60 + 41;
const targetGameTime = (targetDay - 1) * GAME_DAY + targetMins * 60;
const idx = getWeatherPeriodIndex(targetGameTime);
console.log('Target gameTime:', targetGameTime, 'periodIndex:', idx);
console.log('Period start gameTime for that index:', getGameTimeForWeatherIndex(idx));

const dayStart = (targetDay - 1) * GAME_DAY;
const range = getWeatherIndexRangeForDay(dayStart);
console.log('Day start index range:', range);
console.log('All period indices and human times for Day ' + targetDay + ':');
for (let i = range.first; i <= range.last; i++) {
    const gt = getGameTimeForWeatherIndex(i);
    const secsFromDayStart = gt - dayStart;
    const hours = Math.floor((secsFromDayStart / GAME_DAY) * 24);
    const minutes = Math.floor(((secsFromDayStart / GAME_DAY) * 24 % 1) * 60);
    console.log(' index=', i, ' startGT=', gt, ' time=', String(hours).padStart(2,'0')+':'+String(minutes).padStart(2,'0'));
}
