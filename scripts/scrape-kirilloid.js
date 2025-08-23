#!/usr/bin/env node
// Scrape weather data from http://valheim.kirilloid.ru/weather#<seed> using Puppeteer.
// Usage: node scrape-kirilloid.js --start=1 --end=1000 --concurrency=4 --out=out.json

const fs = require('fs');
const path = require('path');
// use puppeteer-extra with stealth plugin to reduce headless detection
const puppeteer = require('puppeteer-extra');
const StealthPlugin = require('puppeteer-extra-plugin-stealth');
puppeteer.use(StealthPlugin());

const argv = require('minimist')(process.argv.slice(2));
const START = parseInt(argv.start || argv.s || 1, 10);
const END = parseInt(argv.end || argv.e || 1000, 10);
const CONCURRENCY = parseInt(argv.concurrency || argv.c || 4, 10);
const OUT = argv.out || 'scraped-weather.jsonl';
const BASE = argv.base || 'http://valheim.kirilloid.ru/weather';
const HEADLESS = !(argv.headful || argv.headless === false);
const DELAY_MIN = 200; // ms
const DELAY_MAX = 800; // ms
const SCROLL_MODE = !!(argv.scroll || argv.mode === 'scroll');
const MAX_ITEMS = parseInt(argv.maxitems || argv.max || 500, 10);
const SCROLL_DELAY = parseInt(argv.scrolldelay || argv.sd || 600, 10);
const MAX_EMPTY_ROUNDS = parseInt(argv.maxempty || 4, 10);

if (START > END) {
  console.error('start must be <= end');
  process.exit(1);
}

(async () => {
  console.log(`Scraping ${START}..${END} -> ${OUT} (concurrency=${CONCURRENCY})`);
  const launchOpts = {headless: HEADLESS, args: ['--disable-features=IsolateOrigins,site-per-process']};
  if (argv.executablePath) launchOpts.executablePath = argv.executablePath;
  const browser = await puppeteer.launch(launchOpts);
  const outStream = fs.createWriteStream(OUT, {flags: 'a'});
  // debug dirs
  const dbgDir = path.resolve(__dirname, 'debug-screens');
  const dbgHtmlDir = path.resolve(__dirname, 'debug-html');
  const dbgLogsDir = path.resolve(__dirname, 'debug-logs');
  try { fs.mkdirSync(dbgDir, {recursive:true}); fs.mkdirSync(dbgHtmlDir, {recursive:true}); fs.mkdirSync(dbgLogsDir, {recursive:true}); } catch(e){}

  const seeds = [];
  for (let i = START; i <= END; i++) seeds.push(i);

  // If scroll mode, we open the page once and load many items by scrolling
  if (SCROLL_MODE) {
    const page = await browser.newPage();
    try {
      await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36');
      await page.setViewport({width: 1200, height: 900});

      console.log('Opening single page and scrolling to load items...');
      await page.goto(BASE + '#1', {waitUntil: 'domcontentloaded', timeout: 30000});

      // selectors we will look for to detect loaded items (flexible)
      const selectors = ['.day', '.forecast', '.days .day', 'table tr', '.weather', '.forecast-row', '.weather-row'];

      let lastCount = 0;
      let emptyRounds = 0;
      for (let round = 0; round < 200; round++) {
        // scroll to bottom
        await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
        await page.waitForTimeout(SCROLL_DELAY);

        // count matching nodes
        const count = await page.evaluate((selectors) => {
          let total = 0;
          for (const s of selectors) {
            try { total += document.querySelectorAll(s).length; } catch(e) {}
          }
          return total;
        }, selectors);

        console.log('Scroll round', round + 1, 'items count ~', count);

        if (count === lastCount) {
          emptyRounds++;
          if (emptyRounds >= MAX_EMPTY_ROUNDS) break;
        } else {
          emptyRounds = 0;
          lastCount = count;
        }
        if (lastCount >= MAX_ITEMS) break;
      }

      // extract loaded items flexibly
      const items = await page.evaluate((selectors) => {
        const out = [];
        // prefer enumerating day-like blocks
        let nodes = [];
        for (const s of selectors) {
          const n = Array.from(document.querySelectorAll(s));
          if (n.length > nodes.length) nodes = n;
        }
        if (!nodes.length) nodes = Array.from(document.querySelectorAll('body *')).slice(0, 0);

        nodes.forEach(n => {
          // try to find a seed in any child anchor href/hash
          let seed = null;
          const a = n.querySelector && n.querySelector('a[href*="#"]');
          if (a && a.href) {
            try { const h = new URL(a.href); seed = h.hash ? h.hash.replace('#','') : null; } catch(e){}
          }
          const text = n.innerText ? n.innerText.trim() : '';
          out.push({seed: seed, text: text});
        });
        return out;
      }, selectors);

      // write items to outStream
      for (const it of items.slice(0, MAX_ITEMS)) {
        outStream.write(JSON.stringify({source: 'scroll', extracted: it, url: BASE}) + '\n');
      }
      console.log('Wrote', Math.min(items.length, MAX_ITEMS), 'items to', OUT);
    } catch (e) {
      console.error('Scroll-mode error:', e && e.message ? e.message : e);
    } finally {
      try { await page.close(); } catch(_){}
      await browser.close();
      outStream.end();
      process.exit(0);
    }
  }

  let active = 0;
  let idx = 0;
  let done = 0;

  async function worker() {
    while (true) {
      const seed = seeds.shift();
      if (seed === undefined) return;
      const page = await browser.newPage();
        // per-page debug collectors
        const consoleMsgs = [];
        const reqFails = [];
        page.on('console', msg => consoleMsgs.push({type: msg.type(), text: msg.text()}));
        page.on('requestfailed', req => reqFails.push({url: req.url(), method: req.method(), failureText: req.failure() && req.failure().errorText}));
        // set a common user agent and viewport to reduce headless detection
        try {
          await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36');
          await page.setViewport({width: 1200, height: 800});
        } catch (e) { /* ignore */ }
      try {
        const url = BASE + '#' + seed;
        await page.goto(url, {waitUntil: 'domcontentloaded', timeout: 20000});

        // Wait briefly for client JS to run and (if present) define data functions
        try {
          await page.waitForFunction('window.getWeathersAt || window.getWeatherForDay || window.document.querySelector(".weather")', {timeout: 3000});
        } catch (e) {
          // continue even if wait fails
        }

        // Evaluate in page to extract structured data if functions exist, otherwise attempt DOM scraping
        const res = await page.evaluate((seed) => {
          function safeCall(fnName, arg) {
            try { if (window[fnName]) return window[fnName](arg); } catch (e) { return {error: String(e)}; }
            return null;
          }

          const out = {seed: seed, url: location.href, timestamp: Date.now(), extracted: {}};

          // Preferred: use exposed functions the site provides if available
          if (window.getWeathersAt) {
            try { out.extracted.weathers = window.getWeathersAt(seed); } catch (e) { out.extracted.weathers = {error: String(e)}; }
          }
          if (window.getGlobalWind) {
            try { out.extracted.wind = window.getGlobalWind(seed); } catch (e) { out.extracted.wind = {error: String(e)}; }
          }

          // Some sites use other names. Try a few fallbacks.
          if (!out.extracted.weathers && typeof window.getWeatherForDay === 'function') {
            try { out.extracted.weathers = window.getWeatherForDay(seed); } catch (e) { out.extracted.weathers = {error: String(e)}; }
          }

          // DOM fallback: collect visible textual weather table/blocks
          if (!out.extracted.weathers) {
            const blocks = [];
            const rows = document.querySelectorAll('table, .day, .weather, .forecast, .days');
            if (rows.length) {
              rows.forEach(r => blocks.push(r.innerText.trim()));
            } else {
              // generic capture of body text (limited)
              blocks.push(document.body.innerText.trim().slice(0, 3000));
            }
            out.extracted.dom = blocks;
          }

          return out;
        }, seed);

        // write JSONL
        outStream.write(JSON.stringify(res) + '\n');
        done++;
        if (done % 50 === 0) console.log(`done ${done} seeds...`);

        // politeness randomized delay
        const delay = Math.floor(Math.random() * (DELAY_MAX - DELAY_MIN + 1)) + DELAY_MIN;
        await new Promise(r => setTimeout(r, delay));
      } catch (err) {
        console.error('Error for seed', seed, err && err.message ? err.message : err);
        // save screenshot + html + logs for debugging
        try {
          const safe = String(seed).replace(/[^0-9a-zA-Z_-]/g,'');
          const screenPath = path.join(dbgDir, `seed-${safe}.png`);
          const htmlPath = path.join(dbgHtmlDir, `seed-${safe}.html`);
          const logPath = path.join(dbgLogsDir, `seed-${safe}.json`);
          try { await page.screenshot({path: screenPath, fullPage: false}); } catch(_){}
          try { const html = await page.content(); fs.writeFileSync(htmlPath, html, 'utf8'); } catch(_){}
          try { fs.writeFileSync(logPath, JSON.stringify({error: String(err), console: consoleMsgs, requestFailures: reqFails}, null, 2), 'utf8'); } catch(_){}
        } catch(_){}
        outStream.write(JSON.stringify({seed, error: String(err), timestamp: Date.now()}) + '\n');
      } finally {
        try { await page.close(); } catch (_) {}
      }
    }
  }

  const workers = [];
  for (let w = 0; w < CONCURRENCY; w++) workers.push(worker());
  await Promise.all(workers);

  outStream.end();
  await browser.close();
  console.log('Finished. Output:', OUT);
})();
