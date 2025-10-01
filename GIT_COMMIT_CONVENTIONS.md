# Git Commit Conventions for Jotunheim Magic Plugin

## CRITICAL REMINDER FOR AI AGENT

**ALWAYS follow this exact format for commit messages:**

```
v[VERSION] - [TYPE]: [Brief description]
```

### Examples:
- `v0.9.5.9.11 - FIX: Table layout grid positioning for action buttons`
- `v0.9.5.9.10 - FEATURE: Add table view toggle functionality`
- `v0.9.5.9.9 - DEBUG: Add console logging for button interactions`
- `v0.9.5.9.8 - REDESIGN: Complete table view implementation`

### Version Management:
- **MANDATORY**: Always increment version in `jotunheim-magic.php` BEFORE committing
- Update the line: ` * Version: v[new.version.number]`
- Use the EXACT version from `jotunheim-magic.php` in commit message
- Format: `v[major].[minor].[patch].[build]`

### Version Increment Rules:
- **CRITICAL**: ONLY EVER INCREMENT THE LAST NUMBER (rightmost) unless explicitly told otherwise
- **DEFAULT BEHAVIOR**: Always increment only the build number (rightmost position)
  - Example: `v0.9.6.0.9` → `v0.9.6.0.10` → `v0.9.6.0.11` → `v0.9.6.0.12`
  - Build numbers can go WAY higher than 9 (e.g., v0.9.6.0.25, v0.9.6.0.100)
  - **NEVER ASSUME** numbers need to "rollover" at 9
- **ONLY CHANGE OTHER NUMBERS** when user explicitly says "increment the patch number" or "increment the minor number"
- **NO AUTOMATIC ROLLOVERS** - User will tell you when to change anything other than the last digit

### Type Categories:
- **FIX**: Bug fixes, corrections
- **FEATURE**: New functionality 
- **DEBUG**: Debugging, logging, diagnostics
- **REDESIGN**: Major UI/UX changes
- **REFACTOR**: Code restructuring
- **UPDATE**: Minor improvements

### REQUIRED WORKFLOW:
1. **FIRST**: Update version number in `jotunheim-magic.php`
2. **SECOND**: Make your code changes
3. **THIRD**: Commit with proper format using the NEW version number

### DO NOT USE:
- Generic messages like "Fix table layout"
- Missing version prefix
- Wrong version format
- Inconsistent typing
- Committing without updating version number first

## THIS IS MANDATORY - NO EXCEPTIONS
## ALWAYS UPDATE PLUGIN VERSION BEFORE COMMITTING