// ==================================
// VALHEIM WEATHER CALENDAR WITH REAL ALGORITHM
// ==================================

// ==================== EASY CONFIGURATION SECTION ====================
// ← UPDATE THESE VALUES FOR EASY CONFIGURATION

// API OVERRIDE SETTINGS (Priority 1 - Highest)
var API_ENABLED = false;  // Set to true to enable API override
var API_ENDPOINT = '';    // Your API URL (e.g., 'https://your-server.com/api/current-day')

// MANUAL DAY OVERRIDE SETTINGS (Priority 2)
var MANUAL_ENABLED = false;                              // Set to true to enable manual override
var MANUAL_START_DAY = 1;                               // What in-game day to start from
var MANUAL_START_DATE = new Date('2025-08-01 19:30:00'); // Real date/time for that day

// SERVER START DATE SETTINGS (Priority 3 - Default)
var SERVER_START_DATE = new Date('2025-08-01 19:30:00'); // When your server started (Day 1)

// ==================== END CONFIGURATION SECTION ====================

// CONFIGURATION SYSTEM - Priority order (higher number = higher priority):
// 1. API Override (highest priority)
// 2. Manual Day Override 
// 3. Server Start Date (default/fallback)

// DEFAULT SERVER START DATE - Fallback method (Priority 3)
var DEFAULT_SERVER_START_DATE = SERVER_START_DATE;

// Configuration variables (will be updated from HTML form OR use values above)
var CONFIG = {
    // API Override (Priority 1)
    apiEnabled: API_ENABLED,
    apiEndpoint: API_ENDPOINT,
    
    // Manual Day Override (Priority 2)
    manualEnabled: MANUAL_ENABLED,
    manualStartDay: MANUAL_START_DAY,
    manualStartDate: MANUAL_START_DATE,
    
    // Server Start Date (Priority 3 - Default)
    serverStartDate: SERVER_START_DATE
};

// Calculate current in-game day based on configuration priority
async function getCurrentGameDay() {
    try {
        // Priority 1: API Override
        if (CONFIG.apiEnabled && CONFIG.apiEndpoint) {
            try {
                const response = await fetch(CONFIG.apiEndpoint);
                if (response.ok) {
                    const data = await response.json();
                    if (data.currentDay && typeof data.currentDay === 'number') {
                        updateConfigStatus('✅ Using API: Day ' + data.currentDay);
                        return Math.max(1, Math.floor(data.currentDay));
                    }
                }
            } catch (apiError) {
                console.warn('API fetch failed, falling back to next method:', apiError);
                updateConfigStatus('⚠️ API failed, using fallback method');
            }
        }
        
        // Priority 2: Manual Day Override
        if (CONFIG.manualEnabled) {
            var now = new Date();
            var timeElapsed = now - CONFIG.manualStartDate; // milliseconds
            var daysElapsed = timeElapsed / (1000 * 60 * 60 * 24); // convert to days
            var currentDay = Math.max(1, Math.floor(CONFIG.manualStartDay + daysElapsed));
            updateConfigStatus('📅 Using Manual Override: Day ' + currentDay);
            return currentDay;
        }
        
        // Priority 3: Server Start Date (Default)
        var now = new Date();
        var timeElapsed = now - CONFIG.serverStartDate;
        var daysElapsed = Math.floor(timeElapsed / (1000 * 60 * 60 * 24));
        var currentDay = Math.max(1, daysElapsed + 1);
        updateConfigStatus('🕐 Using Server Start Date: Day ' + currentDay);
        return currentDay;
        
    } catch (error) {
        console.error('Error calculating current day:', error);
        updateConfigStatus('❌ Error calculating day, using Day 1');
        return 1;
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
        CONFIG.apiEnabled = API_ENABLED; // Use JS default
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
        CONFIG.manualEnabled = MANUAL_ENABLED; // Use JS default
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

// Valheim time constants (from the actual game)
var GAME_DAY = 1200; // Game seconds in a day
var WEATHER_PERIOD = 120; // Weather changes every 120 game seconds  
var WIND_PERIOD = 10; // Wind changes every 10 game seconds
var INTRO_DURATION = 300; // First 5 minutes are always clear

// Weather types and their data (from actual Valheim)
var ENV_STATES = {
    'Clear': { emoji: '☀️', name: 'Clear', wind: [0.0, 1.0] },
    'Heath_clear': { emoji: '☀️', name: 'Clear', wind: [0.0, 1.0] },
    'Twilight_Clear': { emoji: '🌕', name: 'Clear', wind: [0.0, 1.0] },
    'Misty': { emoji: '🌫️', name: 'Misty', wind: [0.0, 0.5] },
    'DeepForest_Mist': { emoji: '🌫️', name: 'Misty', wind: [0.0, 0.5] },
    'Rain': { emoji: '🌧️', name: 'Rain', wind: [0.2, 0.8] },
    'LightRain': { emoji: '🌦️', name: 'Light Rain', wind: [0.1, 0.6] },
    'ThunderStorm': { emoji: '⛈️', name: 'Thunderstorm', wind: [0.8, 1.0] },
    'SwampRain': { emoji: '🌧️', name: 'Rain', wind: [0.2, 0.8] },
    'Snow': { emoji: '🌨️', name: 'Snow', wind: [0.3, 0.8] },
    'Twilight_Snow': { emoji: '🌨️', name: 'Snow', wind: [0.3, 0.8] },
    'SnowStorm': { emoji: '❄️', name: 'Blizzard', wind: [0.7, 1.0] },
    'Twilight_SnowStorm': { emoji: '❄️', name: 'Blizzard', wind: [0.7, 1.0] },
    'Ashrain': { emoji: '☔', name: 'Ash Rain', wind: [0.4, 0.9] }
};

// Biome weather configurations (from actual Valheim)
var ENV_SETUP = {
    'Meadows': [['Clear', 25], ['Rain', 1], ['Misty', 1], ['ThunderStorm', 1], ['LightRain', 1]],
    'BlackForest': [['DeepForest_Mist', 20], ['Rain', 1], ['Misty', 1], ['ThunderStorm', 1]],
    'Swamp': [['SwampRain', 1]],
    'Mountain': [['SnowStorm', 1], ['Snow', 5]],
    'Plains': [['Heath_clear', 5], ['Misty', 1], ['LightRain', 1]],
    'Ocean': [['Clear', 25], ['Rain', 1], ['Misty', 1], ['ThunderStorm', 1], ['LightRain', 1]],
    'Mistlands': [['DeepForest_Mist', 20], ['Rain', 1], ['Misty', 1], ['ThunderStorm', 1]],
    'Ashlands': [['Ashrain', 1]]
};

// Biome display information
var BIOMES = {
    'Meadows': { name: 'Meadows', icon: '⛳' },
    'BlackForest': { name: 'Black Forest', icon: '🌳' },
    'Swamp': { name: 'Swamp', icon: '🐸' },
    'Ocean': { name: 'Ocean', icon: '🌊' },
    'Mountain': { name: 'Mountain', icon: '🏔️' },
    'Plains': { name: 'Plains', icon: '🌺' },
    'Mistlands': { name: 'Mistlands', icon: '🌫️' },
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

// Roll weather based on weighted probabilities (exact Valheim logic)
function rollWeather(weathers, roll) {
    var totalWeight = weathers.reduce(function(sum, weather) { return sum + weather[1]; }, 0);
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

// Get weather for all biomes at specific index (Valheim algorithm)
function getWeathersAt(index) {
    if (index < INTRO_DURATION / WEATHER_PERIOD) {
        return Object.keys(BIOMES).map(function() { return 'Clear'; });
    }
    
    random.init(index);
    var rng = random.rangeFloat(0, 1);
    
    return Object.keys(BIOMES).map(function(biome) {
        var biomeWeathers = ENV_SETUP[biome] || ENV_SETUP['Meadows'];
        return rollWeather(biomeWeathers, rng);
    });
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

// Get sunrise/sunset times (Valheim uses 15% and 85% of day)
function getSunTimes(day) {
    return {
        sunrise: GAME_DAY * 0.15,
        sunset: GAME_DAY * 0.85
    };
}

// UI Update functions
function updateCurrentInfo(day) {
    var currentInfo = document.getElementById('currentInfo');
    if (!currentInfo) return;
    
    var now = new Date();
    var realTime = now.getHours() + ':' + String(now.getMinutes()).padStart(2, '0');
    var gameDay = day - 1;
    var gameTime = gameDay * GAME_DAY;
    
    currentInfo.innerHTML = 
        '<strong>Day ' + day + '</strong> | Real Time: ' + realTime + 
        ' | Game Time: ' + Math.floor(gameTime) + 's | Weather Period: ' + 
        WEATHER_PERIOD + 's';
}

function updateWeatherTable(day) {
    var tableBody = document.getElementById('weatherTableBody');
    if (!tableBody) return;
    
    tableBody.innerHTML = '';
    
    var gameDay = day - 1;
    var startTime = gameDay * GAME_DAY;
    var sunTimes = getSunTimes(day);
    var periodsPerDay = Math.floor(GAME_DAY / WEATHER_PERIOD);
    var biomeKeys = Object.keys(BIOMES);
    
    for (var period = 0; period < periodsPerDay; period++) {
        var gameTime = startTime + period * WEATHER_PERIOD;
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
        if (Math.abs(currentTime - sunTimes.sunrise) < WEATHER_PERIOD / 2) {
            isSpecialTime = true;
            specialNote = 'Sunrise';
            row.style.background = 'rgba(255, 165, 0, 0.3)';
            row.style.color = '#ffa500';
            row.style.fontWeight = 'bold';
        } else if (Math.abs(currentTime - sunTimes.sunset) < WEATHER_PERIOD / 2) {
            isSpecialTime = true;
            specialNote = 'Sunset';
            row.style.background = 'rgba(255, 165, 0, 0.3)';
            row.style.color = '#ffa500';
            row.style.fontWeight = 'bold';
        } else if (period % 2 === 0) {
            row.style.background = 'rgba(255, 255, 255, 0.05)';
        }
        
        // Time cell
        var timeCell = document.createElement('td');
        timeCell.style.cssText = 'padding: 8px 4px; text-align: center; border: 1px solid #444; font-size: 0.8em; font-weight: bold; color: #d4af37;';
        timeCell.innerHTML = isSpecialTime ? 
            timeString + '<br><small>' + specialNote + '</small>' : 
            timeString + '<br><small>+' + (period * WEATHER_PERIOD) + 's</small>';
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
                formatWindDirection(wind.angle) + ' ' + Math.round(wind.angle) + '° ' + windPercent + '%</div>';
            
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
    
    // Add preview periods
    var nextStartTime = (day) * GAME_DAY - GAME_DAY;
    for (var period = 0; period < 3; period++) {
        var gameTime = nextStartTime + period * WEATHER_PERIOD;
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
        timeCell.innerHTML = timeString + '<br><small>+' + (period * WEATHER_PERIOD) + 's</small>';
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
                formatWindDirection(wind.angle) + ' ' + Math.round(wind.angle) + '° ' + windPercent + '%</div>';
            
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
    var startTime = (currentDay - 1) * GAME_DAY;
    var biomeKeys = Object.keys(BIOMES);
    
    biomeKeys.forEach(function(biomeKey) {
        var biome = BIOMES[biomeKey];
        var biomeDiv = document.createElement('div');
        biomeDiv.style.cssText = 'background: rgba(0, 0, 0, 0.5); padding: 15px; border-radius: 8px; border: 1px solid #666;';
        
        var forecastHTML = '<div style="font-size: 1.2em; color: #d4af37; margin-bottom: 10px; text-align: center;">' + biome.icon + ' ' + biome.name + '</div>';
        
        for (var period = 0; period < 12; period++) {
            var gameTime = startTime + period * WEATHER_PERIOD * 2;
            var weatherIndex = Math.floor(gameTime / WEATHER_PERIOD);
            var weathers = getWeathersAt(weatherIndex);
            var wind = getGlobalWind(gameTime);
            
            var biomeIndex = biomeKeys.indexOf(biomeKey);
            var weather = weathers[biomeIndex];
            var envData = ENV_STATES[weather] || { emoji: '❓', name: weather };
            
            var dayProgress = (gameTime % GAME_DAY) / GAME_DAY;
            var displayHour = Math.floor(dayProgress * 24);
            var timeString = String(displayHour).padStart(2, '0') + ':00';
            
            var windRange = envData.wind || [0.0, 1.0];
            var biomeWindIntensity = lerp(windRange[0], windRange[1], wind.intensity);
            var windPercent = Math.round(biomeWindIntensity * 100);
            
            forecastHTML += 
                '<div style="margin: 5px 0; padding: 6px; background: rgba(255,255,255,0.1); border-radius: 4px; display: flex; justify-content: space-between; align-items: center; font-size: 0.9em;">' +
                '<span><strong>' + timeString + '</strong></span>' +
                '<span>' + envData.emoji + ' ' + envData.name + '</span>' +
                '<span style="color: #b0c4de;">' + formatWindDirection(wind.angle) + ' ' + windPercent + '%</span>' +
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

// Initialization
document.addEventListener('DOMContentLoaded', function() {
    var dayInput = document.getElementById('dayInput');
    if (dayInput) {
        // Load configuration from form and calculate current day
        loadConfigurationFromForm();
        
        getCurrentGameDay().then(function(currentDay) {
            CURRENT_GAME_DAY = currentDay;
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
