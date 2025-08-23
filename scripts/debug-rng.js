const { Yj } = require('./valheim-weather.js');
function show(seed, count=12){
  const r = new Yj(seed);
  const out = [];
  for(let i=0;i<count;i++){
    const n = r.next() >>> 0;
    const f = r.random();
    out.push({index:i, next:n, random:f});
  }
  console.log(JSON.stringify({seed, out}, null, 2));
}
show(0, 40);
show(12345, 8);
