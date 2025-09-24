# Jotunheim Magic Plugin - AI Coding Agent Instructions

This WordPress plugin manages a Valheim gaming server with complex integrations for Discord authentication, game mechanics, and player economy systems.

Reminder, i am not doing localhost. I test on the live wordpress website. I want you to commit and push to main main each time, then i'll test. I have safeguards in place, incase you break something.

when you push, we push to main main branch. I will test on the live site.

## Architecture Overview

**Main Entry Point**: `jotunheim-magic.php` - Monolithic include file that loads all subsystems  
**Database Prefix**: `jotun_` for custom tables (not WordPress `wp_` prefix)  
**Organization**: Feature-based directories under `includes/` with class-based implementations

### Core Subsystems

- **Dashboard Config** (`includes/Dashboard/`) - Dynamic admin menu reorganization with normalized database storage
- **Discord Integration** (`includes/Discord/`) - OAuth authentication with role-based access control
- **Valheim Weather** (`includes/Utility/`, `assets/js/valheim-weather.js`) - Precise RNG algorithms matching game mechanics
- **Point of Sale** (`includes/POS/`) - Transaction management with dual AJAX/REST architecture
- **Database APIs** - Comprehensive REST endpoints for all `jotun_*` tables

## Critical Development Patterns

### Include Structure
```php
// Main file includes subsystems in dependency order
include_once(plugin_dir_path(__FILE__) . 'includes/Discord/discord-auth-config.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Dashboard/dashboard-config.php');
```

### Shortcode + Interface Pattern
Each major feature follows this pattern:
```php
// In *-scripts.php: Register shortcode
add_shortcode('feature_name', 'feature_shortcode_function');

// In *-interface.php: Render HTML interface
function feature_interface() { /* HTML output */ }

// Conditional asset loading in shortcode functions
wp_enqueue_script('feature-js', ...);
```

### AJAX Handler Pattern
```php
// Class constructor registers AJAX actions
add_action('wp_ajax_action_name', [$this, 'ajax_handler_method']);

// Handler methods verify nonce and capabilities
if (!wp_verify_nonce($_POST['nonce'], 'action_nonce')) wp_die('Invalid nonce');
```

### Database Class Structure
- `dashboard-db.php` - Legacy single-table storage
- `dashboard-db-normalized.php` - Multi-table normalized storage with migration logic
- Classes handle table creation, data migration, and CRUD operations

## Key Integration Points

### Discord Role Hierarchy
```php
// Role levels: norn > aesir > all_staff > admin > staff > valkyrie > vithar
$discord_roles = get_option('jotunheim_discord_roles');
// Used throughout for permission checking and page access control
```

### Valheim Weather Algorithm
**Critical**: Weather calculations must match kirilloid.github.io exactly
- `ValheimRandom` class implements Unity C# PRNG with precise bit operations
- Weather seeding uses `windTick * WIND_PERIOD / WEATHER_PERIOD` formula
- `WIND_TICK_SHIFT = -6` compatibility constant for live site alignment

### REST API Conventions
- Namespace: `jotunheim/v1` for all custom endpoints
- Authentication: WordPress nonce + capability checking
- Error format: `{ success: false, error: "message" }`
- Success format: `{ success: true, data: {...}, timestamp: "..." }`

## Database Schema Patterns

**Custom Tables**: All use `jotun_` prefix (e.g., `jotun_playerlist`, `jotun_transactions`)  
**Dashboard Storage**: Normalized structure with `jotun_dashboard_sections` and `jotun_dashboard_items`  
**Migration**: Check `tables_exist()` before creating, handle legacy data migration

## Asset Management

**Conditional Loading**: Only enqueue scripts/styles when shortcode is present:
```php
if (has_shortcode($post->post_content, 'shortcode_name')) {
    wp_enqueue_script(...);
}
```

**Asset Organization**: 
- `/assets/css/` - Feature-specific stylesheets
- `/assets/js/` - Feature JavaScript with `/tests/` subdirectory
- Localize scripts with `wp_localize_script()` for AJAX URLs and nonces

## Common Debugging Approaches

1. **Database Issues**: Check `error_log()` calls in dashboard classes for migration problems
2. **Weather Calculations**: Use `/scripts/test-*.js` files to verify RNG alignment
3. **Discord Integration**: Test connection via dashboard config interface
4. **Menu Problems**: Clear dashboard config and reinitialize default structure

## Development Workflow

**Adding Features**: Create subdirectory under `includes/`, follow shortcode+interface pattern  
**Database Changes**: Extend existing `*-db.php` classes, handle migrations  
**Frontend Integration**: Use WordPress REST API with nonce authentication  
**Testing**: Utilize existing test files in `assets/js/tests/` and `scripts/`

## External Dependencies

- **Discord API**: OAuth2 flow with bot token for role verification
- **Valheim Game Data**: Weather/wind calculations must match official game mechanics
- **Google Sheets**: Optional integration for data import/export (see `includes/GoogleSheets/`)
- **WordPress Core**: Heavy reliance on admin hooks, REST API, and user capabilities