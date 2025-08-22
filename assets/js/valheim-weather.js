// =// ==================== WORDPRESS CONFIGURATION LOADING ====================
// Configuration loaded from WordPress admin settings

// Configuration - WordPress settings will override these defaults
let config = {
    apiConfig: {
        enabled: false,
        endpoint: ''
    },
    manualOverride: {
        enabled: true,  // Enable manual override for testing
        startDay: 984,   // Set to 984 as configured
        startDate: '2025-08-22T09:00',
        progression: 'static'  // 'static' means no time progression for testing
    },
    serverStartDate: '2025-08-01T19:30'  // Default server start
};

// Load WordPress configuration if available
async function loadWordPressConfig() {
    try {
        // Check if we're in a WordPress environment with our plugin
        const ajaxurl = weather_ajax ? weather_ajax.ajaxurl : (typeof ajaxurl !== 'undefined' ? ajaxurl : null);
        
        if (ajaxurl) {
            const response = await fetch(ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=get_weather_config'
            });
            
            if (response.ok) {
                const wpConfig = await response.json();
                console.log('Raw WordPress config response:', wpConfig);
                if (wpConfig.success) {
                    // Update config with WordPress settings
                    config.apiConfig.enabled = wpConfig.data.api_enabled;
                    config.apiConfig.endpoint = wpConfig.data.api_endpoint;
                    config.manualOverride.enabled = wpConfig.data.manual_enabled;
                    config.manualOverride.startDay = wpConfig.data.manual_start_day;
                    config.manualOverride.startDate = wpConfig.data.manual_start_date;
                    config.manualOverride.progression = wpConfig.data.manual_progression;
                    config.serverStartDate = wpConfig.data.server_start_date;
                    
                    console.log('Loaded WordPress weather configuration:', config);
                } else {
                    console.warn('WordPress config request failed:', wpConfig);
                }
            }
        }
    } catch (error) {
        console.log('Using default weather configuration (WordPress config not available)');
    }
}

// ==================== END CONFIGURATION SECTION =====================================
// VALHEIM WEATHER CALENDAR WITH REAL ALGORITHM
// ==================================

// CONFIGURATION SYSTEM - Priority order (higher number = higher priority):
// 1. API Override (highest priority) - from WordPress admin
// 2. Manual Day Override - from WordPress admin
// 3. Server Start Date (default/fallback) - from WordPress admin

// Configuration variables (will be updated from WordPress admin OR use defaults)
var CONFIG = {
    // API Override (Priority 1)
    apiEnabled: false,
    apiEndpoint: '',
    
    // Manual Day Override (Priority 2)
    manualEnabled: true,   // Enable for testing
    manualStartDay: 984,   // Set to 984 as configured
    manualStartDate: new Date('2025-08-22T00:00'),
    manualProgressionType: 'static', // 'static', 'real-days', or 'game-time'
    
    // Server Start Date (Priority 3 - Default)
    serverStartDate: new Date('2025-08-01T19:30')
};

// API caching configuration
var API_CACHE_DURATION = 4 * 60 * 60 * 1000; // 4 hours in milliseconds
var API_CACHE_KEY = 'valheim_weather_api_cache';

// Check if cached API data is still valid
function isApiCacheValid() {
    try {
        var cached = localStorage.getItem(API_CACHE_KEY);
        if (!cached) return false;
        
        var data = JSON.parse(cached);
        var now = new Date().getTime();
        var cacheAge = now - data.timestamp;
        
        return cacheAge < API_CACHE_DURATION;
    } catch (error) {
        console.warn('Error checking API cache:', error);
        return false;
    }
}

// Get cached API data if valid
function getCachedApiData() {
    try {
        var cached = localStorage.getItem(API_CACHE_KEY);
        if (!cached) return null;
        
        var data = JSON.parse(cached);
        return data.currentDay;
    } catch (error) {
        console.warn('Error reading API cache:', error);
        return null;
    }
}

// Cache API data
function cacheApiData(currentDay) {
    try {
        var cacheData = {
            currentDay: currentDay,
            timestamp: new Date().getTime()
        };
        localStorage.setItem(API_CACHE_KEY, JSON.stringify(cacheData));
    } catch (error) {
        console.warn('Error caching API data:', error);
    }
}

// Clear API cache (useful for debugging)
function clearApiCache() {
    try {
        localStorage.removeItem(API_CACHE_KEY);
        console.log('API cache cleared');
    } catch (error) {
        console.warn('Error clearing API cache:', error);
    }
}

// Calculate current in-game day based on configuration priority
async function getCurrentGameDay() {
    try {
        // Priority 1: API Override
        if (CONFIG.apiEnabled && CONFIG.apiEndpoint) {
            // Check cache first
            if (isApiCacheValid()) {
                var cachedDay = getCachedApiData();
                if (cachedDay) {
                    updateConfigStatus('✅ Using API (cached): Day ' + cachedDay + ' (cache valid for ' + Math.round((API_CACHE_DURATION - (new Date().getTime() - JSON.parse(localStorage.getItem(API_CACHE_KEY)).timestamp)) / (60 * 60 * 1000)) + ' more hours)');
                    return Math.max(1, Math.floor(cachedDay));
                }
            }
            
            // Cache miss or expired, fetch from API
            try {
                updateConfigStatus('🔄 Fetching from API...');
                const response = await fetch(CONFIG.apiEndpoint);
                if (response.ok) {
                    const data = await response.json();
                    if (data.currentDay && typeof data.currentDay === 'number') {
                        // Cache the result
                        cacheApiData(data.currentDay);
                        updateConfigStatus('✅ Using API (fresh): Day ' + data.currentDay + ' (cached for 4 hours)');
                        return Math.max(1, Math.floor(data.currentDay));
                    }
                }
            } catch (apiError) {
                console.warn('API fetch failed, falling back to next method:', apiError);
                
                // Try to use cached data even if expired as fallback
                var fallbackCache = getCachedApiData();
                if (fallbackCache) {
                    updateConfigStatus('⚠️ API failed, using expired cache: Day ' + fallbackCache);
                    return Math.max(1, Math.floor(fallbackCache));
                }
                
                updateConfigStatus('⚠️ API failed, using fallback method');
            }
        }
        
        // Priority 2: Manual Day Override
        if (CONFIG.manualEnabled) {
            var now = new Date();
            var timeElapsed = now - CONFIG.manualStartDate; // milliseconds
            var currentDay = CONFIG.manualStartDay;
            
            if (CONFIG.manualProgressionType === 'real-days') {
                // 1 real day = 1 in-game day
                var realDaysElapsed = timeElapsed / (1000 * 60 * 60 * 24); // convert to real days
                currentDay = Math.max(1, Math.floor(CONFIG.manualStartDay + realDaysElapsed));
                updateConfigStatus('📅 Using Manual Override: Day ' + currentDay + ' (real-time progression)');
            } else if (CONFIG.manualProgressionType === 'game-time') {
                // 20 minutes real time = 1 in-game day
                var gameSecondsElapsed = timeElapsed / 1000; // convert to seconds
                var gameDaysElapsed = gameSecondsElapsed / GAME_DAY; // GAME_DAY = 1200 seconds = 20 minutes
                currentDay = Math.max(1, Math.floor(CONFIG.manualStartDay + gameDaysElapsed));
                updateConfigStatus('📅 Using Manual Override: Day ' + currentDay + ' (in-game time progression)');
            } else {
                // Static - no progression
                currentDay = CONFIG.manualStartDay;
                updateConfigStatus('📅 Using Manual Override: Day ' + currentDay + ' (static, no progression)');
            }
            
            return currentDay;
        }
        
        // Priority 3: Server Start Date (Default)
        var now = new Date();
        var timeElapsed = now - CONFIG.serverStartDate; // milliseconds
        var gameSecondsElapsed = timeElapsed / 1000; // convert to seconds
        var gameDaysElapsed = gameSecondsElapsed / GAME_DAY; // GAME_DAY = 1200 seconds = 20 minutes
        var currentDay = Math.max(1, Math.floor(gameDaysElapsed) + 1); // Day 1 starts at server start
        updateConfigStatus('🕐 Using Server Start Date: Day ' + currentDay + ' (based on in-game time)');
        return currentDay;
        
    } catch (error) {
        console.error('Error calculating current day:', error);
        updateConfigStatus('❌ Error calculating day, using Day 1');
        return 1;
    }
}

// Calculate current in-game time (total game seconds elapsed since server start)
async function getCurrentGameTime() {
    try {
        // Priority 1: API Override
        if (CONFIG.apiEnabled && CONFIG.apiEndpoint) {
            // For API, we can only get the day, so calculate time within that day based on real time
            // This isn't perfect but it's the best we can do without time-within-day from the API
            var cachedDay = getCachedApiData();
            if (cachedDay) {
                var currentDay = Math.max(1, Math.floor(cachedDay));
                var baseTime = (currentDay - 1) * GAME_DAY;
                // Add current time within the day based on real time progression
                var now = new Date();
                var millisecondsIntoDay = (now.getTime() % (20 * 60 * 1000)); // 20 minutes per game day
                var gameSecondsIntoDay = (millisecondsIntoDay / 1000) * (GAME_DAY / (20 * 60));
                return baseTime + gameSecondsIntoDay;
            }
        }
        
        // Priority 2: Manual Day Override
        if (CONFIG.manualEnabled) {
            var now = new Date();
            var timeElapsed = now - CONFIG.manualStartDate; // milliseconds
            var baseTime = (CONFIG.manualStartDay - 1) * GAME_DAY; // Start of the manual start day
            
            if (CONFIG.manualProgressionType === 'real-days') {
                // 1 real day = 1 in-game day, but we need time within day
                var realDaysElapsed = timeElapsed / (1000 * 60 * 60 * 24); // convert to real days
                var totalGameTime = baseTime + (realDaysElapsed * GAME_DAY);
                return Math.max(0, totalGameTime);
            } else if (CONFIG.manualProgressionType === 'game-time') {
                // 20 minutes real time = 1 in-game day (1200 seconds)
                var gameSecondsElapsed = timeElapsed / 1000; // convert to seconds
                var scaledGameTime = gameSecondsElapsed * (GAME_DAY / (20 * 60)); // Scale real seconds to game seconds
                return Math.max(0, baseTime + scaledGameTime);
            } else {
                // Static - no progression, but we still calculate time within the current day
                var millisecondsIntoDay = (now.getTime() % (20 * 60 * 1000)); // 20 minutes per game day
                var gameSecondsIntoDay = (millisecondsIntoDay / 1000) * (GAME_DAY / (20 * 60));
                return baseTime + gameSecondsIntoDay;
            }
        }
        
        // Priority 3: Server Start Date (Default)
        var now = new Date();
        var timeElapsed = now - CONFIG.serverStartDate; // milliseconds
        var gameSecondsElapsed = timeElapsed / 1000; // convert to seconds
        var scaledGameTime = gameSecondsElapsed * (GAME_DAY / (20 * 60)); // Scale real seconds to game seconds (20 min = 1 game day)
        return Math.max(0, scaledGameTime);
        
    } catch (error) {
        console.error('Error calculating current game time:', error);
        return 0;
    }
}

// Update configuration status message
function updateConfigStatus(message) {
    var statusElement = document.getElementById('configStatus');
    if (statusElement) {
        statusElement.textContent = message;
        statusElement.style.color = message.startsWith('✅') ? '#4CAF50' : 
                                   message.startsWith('⚠️') ? '#FF9800' : 
                                   message.startsWith('❌') ? '#F44336' : '#aaa';
    }
}

// Apply configuration from HTML form
function applyConfiguration() {
    // Get form values
    var apiEndpoint = document.getElementById('apiEndpoint');
    var enableApi = document.getElementById('enableApi');
    var manualStartDay = document.getElementById('manualStartDay');
    var manualStartDate = document.getElementById('manualStartDate');
    var enableManual = document.getElementById('enableManual');
    var serverStartDate = document.getElementById('serverStartDate');
    
    if (!apiEndpoint || !enableApi || !manualStartDay || !manualStartDate || !enableManual || !serverStartDate) {
        console.error('Configuration form elements not found');
        return;
    }
    
    // Update configuration
    CONFIG.apiEnabled = enableApi.checked;
    CONFIG.apiEndpoint = apiEndpoint.value.trim();
    
    CONFIG.manualEnabled = enableManual.checked;
    CONFIG.manualStartDay = parseInt(manualStartDay.value) || 1;
    CONFIG.manualStartDate = new Date(manualStartDate.value);
    
    CONFIG.serverStartDate = new Date(serverStartDate.value);
    
    updateConfigStatus('🔄 Configuration updated, recalculating...');
    
    // Recalculate and update display
    getCurrentGameDay().then(function(newCurrentDay) {
        CURRENT_GAME_DAY = newCurrentDay;
        var dayInput = document.getElementById('dayInput');
        if (dayInput) {
            dayInput.value = CURRENT_GAME_DAY;
            updateWeather();
        }
    });
}

// Load configuration from HTML form on page load
function loadConfigurationFromForm() {
    var apiEndpoint = document.getElementById('apiEndpoint');
    var enableApi = document.getElementById('enableApi');
    var manualStartDay = document.getElementById('manualStartDay');
    var manualStartDate = document.getElementById('manualStartDate');
    var enableManual = document.getElementById('enableManual');
    var serverStartDate = document.getElementById('serverStartDate');
    
    // If form elements exist, use their values, otherwise use JavaScript defaults
    if (apiEndpoint && apiEndpoint.value) {
        CONFIG.apiEndpoint = apiEndpoint.value.trim();
    } else if (apiEndpoint) {
        apiEndpoint.value = CONFIG.apiEndpoint; // Set form to JS default
    }
    
    if (enableApi) {
        CONFIG.apiEnabled = enableApi.checked;
    } else {
        CONFIG.apiEnabled = config.apiConfig.enabled; // Use WordPress default
    }
    
    if (manualStartDay && manualStartDay.value) {
        CONFIG.manualStartDay = parseInt(manualStartDay.value) || 1;
    } else if (manualStartDay) {
        manualStartDay.value = CONFIG.manualStartDay; // Set form to JS default
    }
    
    if (manualStartDate && manualStartDate.value) {
        CONFIG.manualStartDate = new Date(manualStartDate.value);
    } else if (manualStartDate) {
        manualStartDate.value = formatDateForInput(CONFIG.manualStartDate); // Set form to JS default
    }
    
    if (enableManual) {
        CONFIG.manualEnabled = enableManual.checked;
    } else {
        CONFIG.manualEnabled = config.manualOverride.enabled; // Use WordPress default
    }
    
    if (serverStartDate && serverStartDate.value) {
        CONFIG.serverStartDate = new Date(serverStartDate.value);
    } else if (serverStartDate) {
        serverStartDate.value = formatDateForInput(CONFIG.serverStartDate); // Set form to JS default
    }
    
    // Update checkboxes to reflect JS defaults if they exist
    if (enableApi) enableApi.checked = CONFIG.apiEnabled;
    if (enableManual) enableManual.checked = CONFIG.manualEnabled;
}

// Helper function to format date for HTML datetime-local input
function formatDateForInput(date) {
    var year = date.getFullYear();
    var month = String(date.getMonth() + 1).padStart(2, '0');
    var day = String(date.getDate()).padStart(2, '0');
    var hours = String(date.getHours()).padStart(2, '0');
    var minutes = String(date.getMinutes()).padStart(2, '0');
    return year + '-' + month + '-' + day + 'T' + hours + ':' + minutes;
}

var CURRENT_GAME_DAY = 1; // Will be updated by getCurrentGameDay()

// Valheim time constants (authentic kirilloid values)
var GAME_DAY = 1200; // Game seconds in a day - 20 minutes real time (kirilloid authentic)
var WEATHER_PERIOD = 666; // Weather changes every 666 game seconds (kirilloid authentic)
var WIND_PERIOD = 125; // Wind changes every 125 game seconds (kirilloid authentic)
var INTRO_DURATION = 2040; // First intro period (kirilloid authentic)
var INTRO_WEATHER = 'Clear'; // Default weather during intro

// Random class implementation (from kirilloid)
function Random(seed) {
    this.init(seed || 0);
}

Random.prototype.init = function(seed) {
    // XORShift implementation matching Unity's Random
    this._a = ((seed * 0x343fd) + 0x269ec3) >>> 0;
    this._b = this._a;
    this._c = this._a;
    this._d = this._a;
};

Random.prototype.nextUInt = function() {
    var t = this._d;
    var s = this._a;
    this._d = this._c;
    this._c = this._b;
    this._b = s;
    t ^= t << 11;
    t ^= t >>> 8;
    return this._a = t ^ s ^ (s >>> 19);
};

Random.prototype.random = function() {
    return (this.nextUInt() >>> 0) / 0x100000000;
};

Random.prototype.rangeFloat = function(min, max) {
    return min + this.random() * (max - min);
};

var random = new Random(0);

// Biome setup (kirilloid authentic)
var biomeIds = ['Meadows', 'BlackForest', 'Swamp', 'Mountain', 'Plains', 'Ocean', 'Mistlands', 'Ashlands', 'DeepNorth'];

// Environment setup with exact kirilloid weights
var ENV_SETUP = {
    'Meadows': [['Clear', 25], ['Rain', 1], ['Misty', 1], ['ThunderStorm', 1], ['LightRain', 1]],
    'BlackForest': [['DeepForest_Mist', 20], ['Rain', 1], ['Misty', 1], ['ThunderStorm', 1]],
    'Swamp': [['SwampRain', 1]],
    'Mountain': [['SnowStorm', 1], ['Snow', 5]],
    'Plains': [['Heath_clear', 5], ['Misty', 1], ['LightRain', 1]],
    'DeepNorth': [['Twilight_SnowStorm', 1], ['Twilight_Snow', 2], ['Twilight_Clear', 1]],
    'Ashlands': [['Ashrain', 30], ['Misty', 2], ['CinderRain', 4], ['storm', 1]],
    'Mistlands': [['Clear', 15], ['Rain', 1], ['ThunderStorm', 1]],
    'Ocean': [['Rain', 1], ['LightRain', 1], ['Misty', 1], ['Clear', 10], ['ThunderStorm', 1]]
};

// Constants for kirilloid algorithm
var INTRO_WEATHER = 'ThunderStorm';
var INTRO_DURATION = 432000; // Duration of intro weather in seconds (5 days * 86400)
var WIND_PERIOD = 10; // Wind changes every 10 seconds

// Roll weather function (kirilloid authentic)
function rollWeather(weathers, roll) {
    var totalWeight = weathers.reduce(function(weight, weather) { return weight + weather[1]; }, 0);
    var randomWeight = totalWeight * roll;
    var sum = 0;
    for (var i = 0; i < weathers.length; i++) {
        var env = weathers[i][0];
        var weight = weathers[i][1];
        sum += weight;
        if (randomWeight < sum) return env;
    }
    return weathers[weathers.length - 1][0];
}

// Get weathers at specific index (kirilloid authentic)
function getWeathersAt(index) {
    if (index < INTRO_DURATION / WEATHER_PERIOD) {
        return biomeIds.map(function() { return INTRO_WEATHER; });
    }
    random.init(index);
    var rng = random.rangeFloat(0, 1);
    return biomeIds.map(function(biome) {
        return rollWeather(ENV_SETUP[biome], rng);
    });
}

// Wind calculation functions (kirilloid authentic)
function addOctave(time, octave, wind) {
    var period = Math.floor(time / (WIND_PERIOD * 8 / octave));
    random.init(period);
    wind.angle += random.random() * 2 * Math.PI / octave;
    wind.intensity += (random.random() - 0.5) / octave;
}

function clamp01(value) {
    return Math.max(0, Math.min(1, value));
}

function getGlobalWind(time) {
    var wind = {
        angle: 0,
        intensity: 0.5
    };
    addOctave(time, 1, wind);
    addOctave(time, 2, wind);
    addOctave(time, 4, wind);
    addOctave(time, 8, wind);
    wind.intensity = clamp01(wind.intensity);
    wind.angle = (wind.angle * 180 / Math.PI) % 360;
    if (wind.angle < 0) wind.angle += 360;
    return wind;
}

// Weather types and their data (from actual Valheim)
var ENV_STATES = {
    'Clear': { emoji: '☀️', name: 'Clear', wind: [0.1, 0.6] },
    'Heath_clear': { emoji: '☀️', name: 'Clear', wind: [0.0, 1.0] },
    'Twilight_Clear': { emoji: '☀️', name: 'Clear', wind: [0.2, 0.6] },
    'Misty': { emoji: '🌫️', name: 'Fog', wind: [0.1, 0.3] },
    'DeepForest_Mist': { emoji: '🌫️', name: 'Mist', wind: [0.1, 0.3] },
    'Rain': { emoji: '🌧️', name: 'Rain', wind: [0.2, 0.8] },
    'LightRain': { emoji: '🌦️', name: 'Light Rain', wind: [0.1, 0.6] },
    'ThunderStorm': { emoji: '⛈️', name: 'Thunderstorm', wind: [0.8, 1.0] },
    'SwampRain': { emoji: '🌧️', name: 'Heavy Rain', wind: [0.2, 0.8] },
    'Snow': { emoji: '🌨️', name: 'Snow', wind: [0.3, 0.8] },
    'Twilight_Snow': { emoji: '🌨️', name: 'Snow', wind: [0.3, 0.8] },
    'SnowStorm': { emoji: '❄️', name: 'Snow Storm', wind: [0.8, 1.0] },
    'Twilight_SnowStorm': { emoji: '❄️', name: 'Snow Storm', wind: [0.8, 1.0] },
    'Ashrain': { emoji: '🌋', name: 'Ash Rain', wind: [0.3, 0.8] },
    'CinderRain': { emoji: '🔥', name: 'Cinder Rain', wind: [0.5, 1.0] },
    'storm': { emoji: '⛈️', name: 'Storm', wind: [0.8, 1.0] }
};

// Biome display information
var BIOMES = {
    'Meadows': { name: 'Meadows', icon: '⛳' },
    'BlackForest': { name: 'Black Forest', icon: '🌳' },
    'Swamp': { name: 'Swamp', icon: '🐸' },
    'Ocean': { name: 'Ocean', icon: '🌊' },
    'Mountain': { name: 'Mountain', icon: '🏔️' },
    'Plains': { name: 'Plains', icon: '🌺' },
    'Mistlands': { name: 'Mistlands', icon: '☁️' },
    'Ashlands': { name: 'Ashlands', icon: '🔥' }
};

// Unity-compatible random number generator (from Valheim source)
function ValheimRandom(seed) {
    this.state = this.init(seed);
}

ValheimRandom.prototype.init = function(seed) {
    var a = seed >>> 0;
    var b = (this.imul(a, 1812433253) + 1) >>> 0;
    var c = (this.imul(b, 1812433253) + 1) >>> 0;
    var d = (this.imul(c, 1812433253) + 1) >>> 0;
    return (this.state = { a: a, b: b, c: c, d: d });
};

ValheimRandom.prototype.imul = function(a, b) {
    return Math.imul ? Math.imul(a, b) : ((a * b) | 0);
};

ValheimRandom.prototype.random = function() {
    var a = this.state.a, b = this.state.b, c = this.state.c, d = this.state.d;
    var t = b << 9 ^ a;
    var w = (c + (d = d + 1 | 0)) | 0;
    b = b ^ b >>> 2 ^ c ^ c << 10;
    c = c ^ c >>> 13 ^ d ^ d << 3;
    a = a ^ a << 13 ^ t ^ t << 5;
    this.state = { a: a, b: b, c: c, d: d };
    return ((a ^ b ^ c) >>> 0) / 4294967296;
};

ValheimRandom.prototype.rangeFloat = function(min, max) {
    return min + this.random() * (max - min);
};

var random = new ValheimRandom(0);

// Utility functions
function lerp(a, b, t) {
    return a + (b - a) * t;
}

function clamp01(value) {
    return Math.max(0, Math.min(1, value));
}

// Calculate global wind (Valheim algorithm)
function getGlobalWind(time) {
    var wind = { angle: 0, intensity: 0.5 };
    
    function addOctave(time, octave, wind) {
        var period = Math.floor(time / (WIND_PERIOD * 8 / octave));
        random.init(period);
        wind.angle += random.random() * 2 * Math.PI / octave;
        wind.intensity += (random.random() - 0.5) / octave;
    }
    
    addOctave(time, 1, wind);
    addOctave(time, 2, wind);
    addOctave(time, 4, wind);
    addOctave(time, 8, wind);
    
    wind.intensity = clamp01(wind.intensity);
    wind.angle = (wind.angle * 180 / Math.PI) % 360;
    if (wind.angle < 0) wind.angle += 360;
    
    return wind;
}

// Convert angle to compass direction
function formatWindDirection(angle) {
    var directions = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW'];
    var index = Math.round((angle + 11.25) % 360 / 22.5);
    return directions[index % 16] || 'N';
}

// Format wind direction with rotated wind symbol
function formatWindWithSymbol(angle, intensity) {
    var direction = formatWindDirection(angle);
    var windPercent = Math.round(intensity * 100);
    
    // Create a rotated arrow icon using SVG (based on kirilloid's design)
    var windArrow = '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" ' +
        'style="display: inline-block; width: 16px; height: 16px; transform: rotate(' + angle + 'deg); margin-right: 4px; vertical-align: middle;">' +
        '<path stroke="currentColor" fill="currentColor" ' +
        'd="M 16,4 L24,12 L22,14 L17.5,9.5 L17.5,25.5 L14.5,25.5 L14.5,9.5 L10,14 L8,12 L16,4 z" />' +
        '</svg>';
    
    return windArrow + direction + ' ' + Math.round(angle) + '° ' + windPercent + '%';
}

// Get sunrise/sunset times (Valheim uses 15% and 85% of day)
function getSunTimes(day) {
    return {
        sunrise: GAME_DAY * 0.15,
        sunset: GAME_DAY * 0.85
    };
}

// Create the weather display table (cross-browser compatible)
function createWeatherDisplay() {
    var weatherDisplay = document.getElementById('weatherDisplay');
    if (!weatherDisplay) return;
    
    var biomeKeys = biomeIds;
    
    var tableHTML = '<table style="width: 100%; border-collapse: collapse; background: rgba(0, 0, 0, 0.8); border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);">' +
        '<thead><tr>';
    
    // Time column header
    tableHTML += '<th style="padding: 12px 8px; text-align: center; border: 1px solid #444; font-size: 0.9em; background: linear-gradient(135deg, #8b7355, #6b5b47); color: #ffd700; font-weight: bold; min-width: 80px;">Time</th>';
    
    // Biome headers (horizontal text for cross-browser compatibility)
    biomeKeys.forEach(function(biomeKey) {
        var biome = BIOMES[biomeKey];
        tableHTML += '<th style="padding: 12px 8px; text-align: center; border: 1px solid #444; font-size: 0.85em; background: linear-gradient(135deg, #8b7355, #6b5b47); color: #ffd700; font-weight: bold; min-width: 100px;">' + 
            biome.icon + ' ' + biome.name + '</th>';
    });
    
    tableHTML += '</tr></thead><tbody id="weatherTableBody"></tbody></table>';
    
    weatherDisplay.innerHTML = tableHTML;
}

// UI Update functions
async function updateCurrentInfo(day) {
    var currentInfo = document.getElementById('currentInfo');
    if (!currentInfo) return;
    
    try {
        // Get current game time (total seconds since server start)
        var currentGameTime = await getCurrentGameTime();
        var currentTimeInDay = currentGameTime % GAME_DAY;
        var currentWeatherIndex = Math.floor(currentGameTime / WEATHER_PERIOD);
        
        // Calculate display time (in-game time of day)
        var dayProgress = currentTimeInDay / GAME_DAY;
        var displayHour = Math.floor(dayProgress * 24);
        var displayMinute = Math.floor((dayProgress * 24 * 60) % 60);
        var timeString = String(displayHour).padStart(2, '0') + ':' + String(displayMinute).padStart(2, '0');
        
        // Get current weather for all biomes
        var weathers = getWeathersAt(currentWeatherIndex);
        var wind = getGlobalWind(currentGameTime);
        var biomeKeys = biomeIds;
        
        // Build HTML for current conditions
        var html = '<div style="font-size: 1.2em; margin-bottom: 15px;">';
        html += '<strong>Day ' + day + '</strong> - <span style="color: #d4af37;">' + timeString + '</span>';
        html += '</div>';
        
        // Add current weather for each biome in a compact format
        html += '<div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">';
        
        for (var i = 0; i < biomeKeys.length; i++) {
            var biomeKey = biomeKeys[i];
            var biome = BIOMES[biomeKey];
            var weather = weathers[i];
            var envData = ENV_STATES[weather] || { emoji: '❓', name: weather };
            
            // Calculate wind for this biome
            var windRange = envData.wind || [0.0, 1.0];
            var biomeWindIntensity = lerp(windRange[0], windRange[1], wind.intensity);
            
            html += '<div style="background: rgba(0,0,0,0.3); padding: 6px 10px; border-radius: 6px; border: 1px solid #555; text-align: center; min-width: 120px;">';
            html += '<div style="font-size: 0.8em; color: #ccc;">' + biome.icon + ' ' + biome.name + '</div>';
            html += '<div style="font-size: 1.1em; margin: 2px 0;">' + envData.emoji + ' ' + envData.name + '</div>';
            html += '<div style="font-size: 0.8em; color: #b0c4de;">' + formatWindWithSymbol(wind.angle, biomeWindIntensity) + '</div>';
            html += '</div>';
        }
        
        html += '</div>';
        
        // Add next weather change info
        var nextWeatherTime = (currentWeatherIndex + 1) * WEATHER_PERIOD;
        var timeToNext = nextWeatherTime - currentGameTime;
        if (timeToNext > 0) {
            var minutesToNext = Math.floor(timeToNext / 60);
            var secondsToNext = Math.floor(timeToNext % 60);
            html += '<div style="margin-top: 10px; font-size: 0.9em; color: #aaa;">';
            html += 'Next weather change in: ' + minutesToNext + 'm ' + secondsToNext + 's';
            html += '</div>';
        }
        
        currentInfo.innerHTML = html;
        
    } catch (error) {
        console.error('Error updating current info:', error);
        currentInfo.innerHTML = '<strong>Day ' + day + '</strong> - <span style="color: #f44336;">Error loading current weather</span>';
    }
}

function updateWeatherTable(day) {
    var tableBody = document.getElementById('weatherTableBody');
    if (!tableBody) return;
    
    tableBody.innerHTML = '';
    
    var gameDay = day - 1;
    var startTime = gameDay * GAME_DAY;
    var sunTimes = getSunTimes(day);
    var biomeKeys = biomeIds;
    
    // Get selected interval from dropdown (default to 1 hour)
    var intervalSelect = document.getElementById('intervalSelect');
    var selectedInterval = intervalSelect ? parseInt(intervalSelect.value) : 60; // minutes
    
    // Calculate display parameters
    var periodsPerDay = Math.floor((24 * 60) / selectedInterval); // How many periods fit in 24 hours
    var displayInterval = GAME_DAY / periodsPerDay; // Game seconds per period
    
    // Generate time entries: regular intervals + exact weather change moments
    var timeEntries = [];
    
    // Add regular interval entries
    for (var period = 0; period < periodsPerDay; period++) {
        var gameTime = startTime + period * displayInterval;
        timeEntries.push({
            gameTime: gameTime,
            type: 'regular',
            period: period
        });
    }
    
    // Add exact weather change entries
    var maxWeatherPeriods = Math.ceil(GAME_DAY / WEATHER_PERIOD) + 1;
    for (var wp = 0; wp < maxWeatherPeriods; wp++) {
        var weatherChangeTime = startTime + wp * WEATHER_PERIOD;
        if (weatherChangeTime >= startTime && weatherChangeTime < startTime + GAME_DAY) {
            // Check if we already have a regular entry very close to this time
            var hasNearbyEntry = timeEntries.some(function(entry) {
                return Math.abs(entry.gameTime - weatherChangeTime) < 30; // Within 30 seconds
            });
            
            if (!hasNearbyEntry) {
                timeEntries.push({
                    gameTime: weatherChangeTime,
                    type: 'weather_change',
                    weatherPeriod: wp
                });
            }
        }
    }
    
    // Sort all entries by time
    timeEntries.sort(function(a, b) { return a.gameTime - b.gameTime; });
    
    // Display all entries
    for (var i = 0; i < timeEntries.length; i++) {
        var entry = timeEntries[i];
        var gameTime = entry.gameTime;
        var weatherIndex = Math.floor(gameTime / WEATHER_PERIOD);
        var weathers = getWeathersAt(weatherIndex);
        var wind = getGlobalWind(gameTime);
        
        var dayProgress = (gameTime % GAME_DAY) / GAME_DAY;
        var displayHour = Math.floor(dayProgress * 24);
        var displayMinute = Math.floor((dayProgress * 24 * 60) % 60);
        var timeString = String(displayHour).padStart(2, '0') + ':' + String(displayMinute).padStart(2, '0');
        
        var row = document.createElement('tr');
        var currentTime = gameTime % GAME_DAY;
        
        var isSpecialTime = false;
        var specialNote = '';
        if (Math.abs(currentTime - sunTimes.sunrise) < 60) { // Within 1 minute of sunrise
            isSpecialTime = true;
            specialNote = 'Sunrise';
            row.style.background = 'rgba(255, 165, 0, 0.3)';
            row.style.color = '#ffa500';
            row.style.fontWeight = 'bold';
        } else if (Math.abs(currentTime - sunTimes.sunset) < 60) { // Within 1 minute of sunset
            isSpecialTime = true;
            specialNote = 'Sunset';
            row.style.background = 'rgba(255, 165, 0, 0.3)';
            row.style.color = '#ffa500';
            row.style.fontWeight = 'bold';
        } else if (entry.type === 'weather_change') {
            // Weather change entries get special highlighting
            row.style.background = 'rgba(100, 200, 255, 0.2)';
            row.style.border = '1px solid #64c8ff';
            specialNote = 'weather';
        } else if (i % 2 === 0) {
            row.style.background = 'rgba(255, 255, 255, 0.05)';
        }
        
        // Time cell
        var timeCell = document.createElement('td');
        timeCell.style.cssText = 'padding: 8px 4px; text-align: center; border: 1px solid #444; font-size: 0.8em; font-weight: bold; color: #d4af37;';
        
        timeCell.innerHTML = isSpecialTime ? 
            timeString + '<br><small>' + specialNote + '</small>' : 
            (entry.type === 'weather_change' ? timeString + '<br><small>weather</small>' : timeString);
        row.appendChild(timeCell);
        
        // Weather for each biome
        biomeKeys.forEach(function(biomeKey, index) {
            var weather = weathers[index];
            var envData = ENV_STATES[weather] || { emoji: '❓', name: weather };
            var cell = document.createElement('td');
            
            cell.style.cssText = 'padding: 8px 4px; text-align: center; border: 1px solid #444; font-size: 0.75em;';
            
            var windRange = envData.wind || [0.0, 1.0];
            var biomeWindIntensity = lerp(windRange[0], windRange[1], wind.intensity);
            var windPercent = Math.round(biomeWindIntensity * 100);
            
            cell.innerHTML = 
                '<div>' + envData.emoji + ' ' + envData.name + '</div>' +
                '<div style="font-size: 0.9em; color: #b0c4de;">' + 
                formatWindWithSymbol(wind.angle, biomeWindIntensity) + '</div>';
            
            row.appendChild(cell);
        });
        
        if (day === CURRENT_GAME_DAY && period === 0) {
            row.style.background = 'rgba(255, 215, 0, 0.2)';
            row.style.border = '2px solid #ffd700';
        }
        
        tableBody.appendChild(row);
    }
    
    // Add next day preview
    var separatorRow = document.createElement('tr');
    separatorRow.style.cssText = 'background: linear-gradient(135deg, #4a3728, #2c1810); color: #ffd700; font-size: 1.1em;';
    separatorRow.innerHTML = '<td colspan="9" style="padding: 8px; text-align: center; border: 1px solid #444; font-weight: bold;">Day ' + (day + 1) + ' Preview</td>';
    tableBody.appendChild(separatorRow);
    
    // Add preview periods (show first 3 30-minute intervals of next day)
    var nextStartTime = day * GAME_DAY;
    for (var period = 0; period < 3; period++) {
        var gameTime = nextStartTime + period * displayInterval;
        var weatherIndex = Math.floor(gameTime / WEATHER_PERIOD);
        var weathers = getWeathersAt(weatherIndex);
        var wind = getGlobalWind(gameTime);
        
        var dayProgress = (gameTime % GAME_DAY) / GAME_DAY;
        var displayHour = Math.floor(dayProgress * 24);
        var displayMinute = Math.floor((dayProgress * 24 * 60) % 60);
        var timeString = String(displayHour).padStart(2, '0') + ':' + String(displayMinute).padStart(2, '0');
        
        var row = document.createElement('tr');
        row.style.opacity = '0.6';
        
        var timeCell = document.createElement('td');
        timeCell.style.cssText = 'padding: 8px 4px; text-align: center; border: 1px solid #444; font-size: 0.8em; font-weight: bold; color: #d4af37;';
        timeCell.innerHTML = timeString;
        row.appendChild(timeCell);
        
        biomeKeys.forEach(function(biomeKey, index) {
            var weather = weathers[index];
            var envData = ENV_STATES[weather] || { emoji: '❓', name: weather };
            var cell = document.createElement('td');
            cell.style.cssText = 'padding: 8px 4px; text-align: center; border: 1px solid #444; font-size: 0.75em;';
            
            var windRange = envData.wind || [0.0, 1.0];
            var biomeWindIntensity = lerp(windRange[0], windRange[1], wind.intensity);
            var windPercent = Math.round(biomeWindIntensity * 100);
            
            cell.innerHTML = 
                '<div>' + envData.emoji + ' ' + envData.name + '</div>' +
                '<div style="font-size: 0.9em; color: #b0c4de;">' + 
                formatWindWithSymbol(wind.angle, biomeWindIntensity) + '</div>';
            
            row.appendChild(cell);
        });
        
        tableBody.appendChild(row);
    }
}

function showForecast() {
    var forecastSection = document.getElementById('forecastSection');
    var forecastGrid = document.getElementById('forecastGrid');
    if (!forecastSection || !forecastGrid) return;
    
    forecastSection.style.display = 'block';
    forecastGrid.innerHTML = '';
    
    var currentDay = parseInt(document.getElementById('dayInput').value);
    var startTime = (currentDay - 1) * GAME_DAY; // Start of the selected day
    var biomeKeys = biomeIds;
    
    biomeKeys.forEach(function(biomeKey) {
        var biome = BIOMES[biomeKey];
        var biomeDiv = document.createElement('div');
        biomeDiv.style.cssText = 'background: rgba(0, 0, 0, 0.5); padding: 15px; border-radius: 8px; border: 1px solid #666;';
        
        var forecastHTML = '<div style="font-size: 1.2em; color: #d4af37; margin-bottom: 10px; text-align: center;">' + biome.icon + ' ' + biome.name + '</div>';
        
        // Sample weather every 2 hours (2/24 of a game day)
        var hoursInterval = 2;
        var timeInterval = (hoursInterval / 24) * GAME_DAY; // 2 hours = 1/12 of game day = 100 seconds
        var numSamples = Math.floor(24 / hoursInterval); // 12 samples for 2-hour intervals
        
        for (var i = 0; i < numSamples; i++) {
            var gameTime = startTime + (i * timeInterval);
            var weatherIndex = Math.floor(gameTime / WEATHER_PERIOD);
            var weathers = getWeathersAt(weatherIndex);
            var wind = getGlobalWind(gameTime);
            
            var biomeIndex = biomeKeys.indexOf(biomeKey);
            var weather = weathers[biomeIndex];
            var envData = ENV_STATES[weather] || { emoji: '❓', name: weather };
            
            // Calculate display time
            var timeInDay = gameTime - startTime;
            var dayProgress = timeInDay / GAME_DAY;
            var displayHour = Math.floor(dayProgress * 24);
            var displayMinute = Math.floor((dayProgress * 24 * 60) % 60);
            var timeString = String(displayHour).padStart(2, '0') + ':' + String(displayMinute).padStart(2, '0');
            
            var windRange = envData.wind || [0.0, 1.0];
            var biomeWindIntensity = lerp(windRange[0], windRange[1], wind.intensity);
            
            forecastHTML += 
                '<div style="margin: 5px 0; padding: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; display: flex; justify-content: space-between; align-items: center; font-size: 0.9em;">' +
                '<span style="min-width: 60px;"><strong>' + timeString + '</strong></span>' +
                '<span style="display: flex; align-items: center; gap: 5px;">' + envData.emoji + ' ' + envData.name + '</span>' +
                '<span style="color: #b0c4de; text-align: right;">' + formatWindWithSymbol(wind.angle, biomeWindIntensity) + '</span>' +
                '</div>';
        }
        
        biomeDiv.innerHTML = forecastHTML;
        forecastGrid.appendChild(biomeDiv);
    });
}

// Event handlers
function changeDay(delta) {
    var dayInput = document.getElementById('dayInput');
    if (!dayInput) return;
    
    var newDay = Math.max(1, parseInt(dayInput.value) + delta);
    dayInput.value = newDay;
    updateWeather();
}

function goToCurrentDay() {
    var dayInput = document.getElementById('dayInput');
    if (!dayInput) return;
    
    // Recalculate current day in case time has passed or configuration changed
    getCurrentGameDay().then(function(newCurrentDay) {
        CURRENT_GAME_DAY = newCurrentDay;
        dayInput.value = CURRENT_GAME_DAY;
        updateWeather();
    });
}

function updateWeather() {
    var dayInput = document.getElementById('dayInput');
    if (!dayInput) return;
    
    var day = parseInt(dayInput.value);
    updateCurrentInfo(day);
    updateWeatherTable(day);
    
    var forecastSection = document.getElementById('forecastSection');
    if (forecastSection) {
        forecastSection.style.display = 'none';
    }
}

// Function to update CONFIG from WordPress config
function updateConfigFromWordPress() {
    CONFIG.apiEnabled = config.apiConfig.enabled;
    CONFIG.apiEndpoint = config.apiConfig.endpoint;
    CONFIG.manualEnabled = config.manualOverride.enabled;
    CONFIG.manualStartDay = config.manualOverride.startDay;
    CONFIG.manualStartDate = new Date(config.manualOverride.startDate);
    CONFIG.manualProgressionType = config.manualOverride.progression;
    CONFIG.serverStartDate = new Date(config.serverStartDate);
    
    // Debug log
    console.log('Updated CONFIG from WordPress:', CONFIG);
}

// Initialization
document.addEventListener('DOMContentLoaded', async function() {
    // Load WordPress configuration first
    await loadWordPressConfig();
    updateConfigFromWordPress();
    
    // Create the weather display table
    createWeatherDisplay();
    
    var dayInput = document.getElementById('dayInput');
    if (dayInput) {
        // Load configuration from form and calculate current day
        loadConfigurationFromForm();
        
        getCurrentGameDay().then(function(currentDay) {
            CURRENT_GAME_DAY = currentDay;
            dayInput.value = CURRENT_GAME_DAY;
            updateWeather();
        }).catch(function(error) {
            console.log('Error getting current day, using default:', error);
            // Fallback to a reasonable default
            CURRENT_GAME_DAY = 983;
            dayInput.value = CURRENT_GAME_DAY;
            updateWeather();
        });
        
        // Update every 30 seconds, and recalculate current day every 5 minutes
        var updateCount = 0;
        setInterval(function() {
            updateCurrentInfo(parseInt(dayInput.value));
            updateCount++;
            
            // Every 10 intervals (5 minutes), recalculate the current day
            if (updateCount >= 10) {
                getCurrentGameDay().then(function(newCurrentDay) {
                    if (newCurrentDay !== CURRENT_GAME_DAY) {
                        CURRENT_GAME_DAY = newCurrentDay;
                        // If we're viewing the current day, update it
                        if (parseInt(dayInput.value) === CURRENT_GAME_DAY - 1) {
                            dayInput.value = CURRENT_GAME_DAY;
                            updateWeather();
                        }
                    }
                }).catch(function(error) {
                    console.log('Error updating current day:', error);
                });
                updateCount = 0;
            }
        }, 30000);
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft') {
        changeDay(-1);
    } else if (e.key === 'ArrowRight') {
        changeDay(1);
    } else if (e.key === 'Home') {
        goToCurrentDay();
    } else if (e.key === 'f' || e.key === 'F') {
        showForecast();
    }
});
