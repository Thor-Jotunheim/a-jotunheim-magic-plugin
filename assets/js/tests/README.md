# Valheim Weather Algorithm Tests

This directory contains organized test files for validating the Valheim weather algorithm against the kirilloid reference.

## Test Files

### `day-984-verification.js`
**Purpose**: Final verification test that confirms Day 984 shows ThunderStorm in BlackForest at 13:41  
**Usage**: `node day-984-verification.js`  
**Expected Result**: Should show ThunderStorm for BlackForest at Day 984 13:41  
**Status**: ✅ Working - confirms the algorithm fix

### `final-verification.js`
**Purpose**: General weather algorithm verification for multiple days and times  
**Usage**: `node final-verification.js`  
**Expected Result**: Shows weather patterns for various test cases  
**Status**: ✅ Working - comprehensive algorithm test

### `compare-rangeFloat.js`
**Purpose**: Compares different rangeFloat implementations to identify correct algorithm  
**Usage**: `node compare-rangeFloat.js`  
**Expected Result**: Demonstrates differences between standard and Unity rangeFloat implementations  
**Status**: ✅ Working - shows why the fix was needed

### `test-corrected-simple.js`
**Purpose**: Simple test showing weather for a specific day with corrected algorithm  
**Usage**: `node test-corrected-simple.js`  
**Expected Result**: Basic weather output for verification  
**Status**: ✅ Working - simple day-specific test

## Key Findings

The root cause of weather synchronization issues was the `rangeFloat` implementation:

- **Incorrect (Unity-specific)**: `max - random * (max - min)`
- **Correct (Standard)**: `min + random * (max - min)`

The kirilloid reference uses the standard implementation, not the Unity-specific one.

## Algorithm Parameters (Verified)

- `GAME_DAY = 1800` (30 minutes real time = 1 game day)
- `WEATHER_PERIOD = 666` (weather changes every 666 game seconds)
- `WIND_PERIOD = 125` (wind changes every 125 game seconds)
- `INTRO_DURATION = 2040` (initial thunderstorm period)

## Running Tests

All tests are Node.js compatible and can be run from this directory:

```bash
cd assets/js/tests
node day-984-verification.js
node final-verification.js
node compare-rangeFloat.js
node test-corrected-simple.js
```

## Verification Status

✅ **Fixed**: Day 984 13:41 now shows ThunderStorm in BlackForest  
✅ **Fixed**: rangeFloat implementation matches kirilloid reference  
✅ **Fixed**: Weather synchronization with kirilloid site  
✅ **Organized**: All test files properly organized in tests directory
