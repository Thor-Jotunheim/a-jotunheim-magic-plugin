// Simple test to verify kirilloid weather algorithm for Day 984
const fs = require('fs');

// Read the weather algorithm file
const weatherCode = fs.readFileSync('./assets/js/valheim-weather.js', 'utf8');

// Extract the constants and functions we need
const GAME_DAY = 1800; // 30 minutes real time
const WEATHER_PERIOD = 300; // 5 minutes

console.log('Testing Day 984 weather algorithm...');
console.log('Expected day from config: 984');
console.log('GAME_DAY:', GAME_DAY, 'seconds');
console.log('WEATHER_PERIOD:', WEATHER_PERIOD, 'seconds');

// Calculate weather index for Day 984 at 13:41
const day984StartTime = 984 * GAME_DAY; // Total seconds at start of day 984
const time1341 = day984StartTime + (13.68333 * 3600); // 13:41 in seconds (13 + 41/60)
const weatherIndex1341 = Math.floor(time1341 / WEATHER_PERIOD);

console.log('Day 984 start time:', day984StartTime, 'seconds');
console.log('Time at 13:41:', time1341, 'seconds');
console.log('Weather index at 13:41:', weatherIndex1341);

// Check if this matches what the user expects
const expectedWeatherChanges = Math.floor(984 * GAME_DAY / WEATHER_PERIOD);
console.log('Total weather changes by day 984:', expectedWeatherChanges);

// Calculate some nearby weather times for Day 984
console.log('\nWeather changes around Day 984:');
for (let i = -2; i <= 2; i++) {
    const weatherIndex = expectedWeatherChanges + i;
    const weatherTime = weatherIndex * WEATHER_PERIOD;
    const dayNum = Math.floor(weatherTime / GAME_DAY) + 1;
    const timeInDay = weatherTime % GAME_DAY;
    const hours = Math.floor(timeInDay / 3600 * 24);
    const minutes = Math.floor((timeInDay / 3600 * 24 % 1) * 60);
    const timeString = String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0');
    
    console.log(`  Index ${weatherIndex}: Day ${dayNum} at ${timeString}`);
}
