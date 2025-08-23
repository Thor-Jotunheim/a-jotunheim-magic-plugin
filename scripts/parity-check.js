// parity-check.js
// Run quick parity checks between the JS and PHP implementations (PHP optional).
// Usage: node parity-check.js [seed] [startDay] [endDay]
// Example: node parity-check.js 9BCp6a4KQo 1 10

const { execSync } = require('child_process');
const fs = require('fs');

const seed = process.argv[2] || '0';
const from = parseInt(process.argv[3] || '1', 10);
const to = parseInt(process.argv[4] || (from + 9), 10);

// Load local JS generator (valheim-weather.js) which exposes functions in the file.
// We will require('./valheim-weather.js') if it was modularized; as a fallback we'll spawn a node subprocess that runs test-valheim-weather.js

function runNodeParity() {
  try {
    const cmd = `node test-valheim-weather.js ${seed} ${from} ${to}`;
    console.log('Running Node parity test:', cmd);
    const out = execSync(cmd, { encoding: 'utf8' });
    console.log(out);
  } catch (e) {
    console.error('Node parity test failed:', e.message);
  }
}

function runPhpComparison() {
  try {
    // test-valheim-weather.php should exist and accept seed/from/to
    const phpScript = 'test-valheim-weather.php';
    if (!fs.existsSync(phpScript)) {
      console.log('PHP parity script not found:', phpScript);
      return;
    }
    const cmd = `php ${phpScript} ${seed} ${from} ${to}`;
    console.log('Running PHP parity test:', cmd);
    const out = execSync(cmd, { encoding: 'utf8' });
    console.log(out);
  } catch (e) {
    console.error('PHP parity test failed (php-cli may not be available):', e.message);
  }
}

console.log('Parity check — seed:', seed, 'range:', from, '->', to);
runNodeParity();
runPhpComparison();

console.log('Done.');
