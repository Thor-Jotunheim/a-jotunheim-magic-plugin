// Node port of kirilloid RNG and weather/wind generator
class Yj {
  constructor(t){ this.init(t); }
  init(e){ const t = e >>> 0; const r = Math.imul(t,1812433253) + 1 >>> 0; const i = Math.imul(r,1812433253) + 1 >>> 0; const a = Math.imul(i,1812433253) + 1 >>> 0; this.state = {a:t,b:r,c:i,d:a}; return this.state; }
  next(){ const e = this.state.a ^ (this.state.a << 11); this.state.a = this.state.b; this.state.b = this.state.c; this.state.c = this.state.d; this.state.d = (this.state.d ^ (this.state.d >>> 19) ^ e ^ (e >>> 8)); return this.state.d; }
  random(){ return (this.next() << 9 >>> 0) / 4294966784; }
  rangeFloat(a,b){ return b - this.random() * (b - a); }
}

const g = { q:125, p:666, h:1800, j:'Clear', i:3600 };
const rg = ["Meadows","BlackForest","Swamp","Mountain","DeepNorth","Plains","Ashlands","Mistlands","Ocean"];
const om = {
  Meadows:[["Clear",25],["Rain",1],["Misty",1],["ThunderStorm",1],["LightRain",1]],
  BlackForest:[["DeepForest_Mist",20],["Rain",1],["Misty",1],["ThunderStorm",1]],
  Swamp:[["SwampRain",1]],
  Mountain:[["SnowStorm",1],["Snow",5]],
  DeepNorth:[["Twilight_SnowStorm",1],["Twilight_Snow",2],["Twilight_Clear",1]],
  Plains:[["Heath_clear",5],["Misty",1],["LightRain",1]],
  Ashlands:[["Ashlands_ashrain",30],["Ashlands_misty",2],["Ashlands_CinderRain",4],["Ashlands_storm",1]],
  Mistlands:[["Mistlands_clear",15],["Mistlands_rain",1],["Mistlands_thunder",1]],
  Ocean:[["Rain",1],["LightRain",1],["Misty",1],["Clear",10],["ThunderStorm",1]]
};

function og(weatherSeed, ig){
  if (!weatherSeed || weatherSeed < g.i / g.p) { return rg.map(()=>g.j); }
  ig.init(weatherSeed);
  var t = ig.rangeFloat(0,1);
  return rg.map(function(b){ var list = om[b]; var total = list.reduce((s,x)=>s+x[1],0) * t; var acc=0; for(var i=0;i<list.length;i++){ acc += list[i][1]; if (total < acc) return list[i][0]; } return list.at(-1)[0]; });
}
function ag(e,t,r,ig){ var i = Math.floor(e / (8 * g.q / t)); ig.init(i); r.angle += 2 * ig.random() * Math.PI / t; r.intensity += (ig.random() - .5) / t; }
function ng(e,ig){ var t = {angle:0,intensity:.5}; ag(e,1,t,ig); ag(e,2,t,ig); ag(e,4,t,ig); ag(e,8,t,ig); t.intensity = Math.max(0,Math.min(1,t.intensity)); t.angle = 180 * t.angle / Math.PI % 360; return t; }

module.exports = { Yj, og, ng, g, rg };
