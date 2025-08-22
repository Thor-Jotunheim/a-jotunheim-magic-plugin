# Valheim Weather Algorithm Tests

This directory contains test files for verifying the Valheim weather algorithm implementation.

## Test Files

### `final-verification.js`
**Purpose:** Comprehensive weather algorithm verification  
**Usage:** `node final-verification.js`  
**Description:** Tests the complete weather algorithm with authentic kirilloid implementation. Verifies that specific weather indices produce the correct weather patterns for all biomes. Great for confirming the algorithm works correctly after changes.

### `compare-rangeFloat.js`  
**Purpose:** Compare old vs new rangeFloat implementations  
**Usage:** `node compare-rangeFloat.js`  
**Description:** Demonstrates the difference between the incorrect `min + random * range` and correct `max - random * range` rangeFloat implementations. Shows how the fix changes weather selection. Useful for understanding why the original algorithm didn't match kirilloid.

### `test-corrected-simple.js`
**Purpose:** Simple weather algorithm test for specific days  
**Usage:** `node test-corrected-simple.js`  
**Description:** Node.js compatible test that checks weather patterns for Day 984 and surrounding days. Includes thunderstorm detection and timing verification. Good for testing weather on specific days.

## Running Tests

All tests are Node.js compatible and can be run from the command line:

```bash
cd assets/js/tests
node final-verification.js
node compare-rangeFloat.js  
node test-corrected-simple.js
```

## Test Data

The tests use the authentic kirilloid weather configuration:
- `GAME_DAY = 1800` seconds (30 minutes real time)
- `WEATHER_PERIOD = 666` seconds (11.1 minutes)  
- `INTRO_DURATION = 2040` seconds
- Unity-compatible XorShift random number generator
- Correct `max - random * range` rangeFloat implementation

## Expected Results

- **final-verification.js:** Should show ThunderStorm in BlackForest and Ocean biomes at weather index 2653
- **compare-rangeFloat.js:** Should show different weather results between old/new rangeFloat 
- **test-corrected-simple.js:** Should show weather changes on Day 984 with no hardcoded fallbacks

These tests verify that the weather algorithm now matches the authentic kirilloid implementation.
