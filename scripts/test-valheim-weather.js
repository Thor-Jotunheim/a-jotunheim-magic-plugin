const { Yj, og, ng } = require('./valheim-weather');
const fs = require('fs');

function sampleSeeds(seeds){
  seeds.forEach(s=>{
    const ig = new Yj(0);
    const wind = ng(s * 125, ig);
    const weatherSeed = Math.floor((s * 125) / 666);
    const ig2 = new Yj(0);
    const weathers = og(weatherSeed, ig2);
    console.log(`Seed ${s}: wind angle=${Math.round(wind.angle)}, int=${Math.round(wind.intensity*100)}%, biome[1]=${weathers[1]}`);
  });
}

const seeds = [1,2,100,1000,12345,54321];
sampleSeeds(seeds);
