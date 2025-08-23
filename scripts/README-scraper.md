Puppeteer scraper for kirilloid weather

What this does
- Loads http://valheim.kirilloid.ru/weather#<seed> in a headless Chromium instance.
- Runs the site's JavaScript in the page context and tries to call exposed functions such as `getWeathersAt` and `getGlobalWind` to extract structured data.
- Falls back to DOM text capture when functions aren't present.
- Writes one JSON object per line (JSONL) to the output file.

Why use this
- The kirilloid page computes weather client-side; a simple HTTP GET won't produce the rendered data. A headless browser executes the JS and lets us extract the same values.

Requirements
- Node.js 14+ and npm/yarn
- Installs puppeteer and minimist

Install

Open PowerShell and run:

```powershell
cd "C:\Users\CalLu\OneDrive\Documents\GitHub\a-jotunheim-magic-plugin\scripts"
npm init -y; npm i puppeteer minimist
```

Run

```powershell
# scrape seeds 1..1000 with 4 concurrent pages
node scrape-kirilloid.js --start=1 --end=1000 --concurrency=4 --out=../Google\ Sheets/Super\ Hammer/Prefarb\ Import/scraped-weather.jsonl
```

Notes and caveats
- Respect the remote site's robots and rate limits. Don't run high-concurrency scrapes without permission.
- If the site blocks headless browsers, consider using puppeteer-extra with stealth plugins or a small delay/lesser concurrency.
- The script writes JSONL for easy incremental runs and resumability. You can later import/aggregate.
- I didn't run the scraper here; run it locally where you have network access.

Next steps (suggested)
- Import the JSONL into your WordPress plugin code and create an endpoint that returns precomputed weather for a seed/day.
- Add a small local cache and an index file mapping seed->file offset for fast lookups.
- If you prefer, we can implement a server-side scraper in PHP using a headless browser service or call a Node microservice to serve cached JSON to your plugin.
