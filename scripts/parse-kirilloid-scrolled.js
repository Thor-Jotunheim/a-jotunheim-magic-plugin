#!/usr/bin/env node
// Parse the kirilloid-scrolled-v2.json produced by the in-browser extractor
// Usage: node parse-kirilloid-scrolled.js ../Downloads/kirilloid-scrolled-v2.json ../parsed-kirilloid.json

const fs = require('fs');
const argv = process.argv.slice(2);
const inPath = argv[0] || process.env.USERPROFILE + '\\Downloads\\kirilloid-scrolled-v2.json';
const outPath = argv[1] || './parsed-kirilloid.json';

if (!fs.existsSync(inPath)) {
  console.error('Input file not found:', inPath);
  process.exit(2);
}

const raw = JSON.parse(fs.readFileSync(inPath, 'utf8'));
const items = raw.extracted || raw;

// heuristics
const BIOMES = ['Meadows','Black forest','Swamp','Ocean','Mountain','Plains','Mistlands','Ashlands'];

function tokenizeTextBlock(text){
  return text.split(/\r?\n/).map(s=>s.trim()).filter(s=>s.length>0);
}

// choose the longest text block
let textBlock = '';
for (const it of items) {
  if (it.text && it.text.length > textBlock.length) textBlock = it.text;
}
if (!textBlock) {
  console.error('No text block found to parse');
  process.exit(1);
}

const lines = tokenizeTextBlock(textBlock);

const timeRe = /^(\d{1,2}:\d{2}|Sunrise|Sunset)$/i;
const dayRe = /^Day\s*(\d+)/i;

let parsed = {source: raw.source || 'kirilloid', url: raw.url, days: {}};
let currentDay = 1;
let i=0;
while (i < lines.length) {
  const line = lines[i];
  const dayMatch = line.match(dayRe);
  if (dayMatch) { currentDay = parseInt(dayMatch[1], 10); i++; continue; }

  const timeMatch = line.match(timeRe);
  if (timeMatch) {
    const time = timeMatch[1];
    // gather next BIOMES.length values
    const values = [];
    let j = i+1;
    while (values.length < BIOMES.length && j < lines.length) {
      const candidate = lines[j];
      // skip lines that look like numeric headers or repeated labels
      if (/^(Weather|day|time)$/i.test(candidate)) { j++; continue; }
      values.push(candidate);
      j++;
    }
    // if values collected less than BIOMES, pad with nulls
    while (values.length < BIOMES.length) values.push(null);

    if (!parsed.days[currentDay]) parsed.days[currentDay] = [];
    const entry = {time: time, byBiome: {}};
    for (let k=0;k<BIOMES.length;k++) entry.byBiome[BIOMES[k]] = values[k];
    parsed.days[currentDay].push(entry);

    i = j; // continue after values
    continue;
  }

  i++;
}

fs.writeFileSync(outPath, JSON.stringify(parsed, null, 2), 'utf8');
console.log('Wrote parsed file to', outPath);
