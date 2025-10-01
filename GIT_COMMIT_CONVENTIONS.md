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
- **DEFAULT**: Only increment the LAST number (build) for regular commits
  - Example: `v0.9.5.9.12` → `v0.9.5.9.13`
  - Build number can go higher than 9 (e.g., v0.9.5.9.25)
- **SPECIAL**: Only increment other numbers when explicitly told by user
- **ROLLOVER RULES**: When numbers exceed 9, rollover to next level:
  - `v0.9.5.9.X` → `v0.9.6.0.0` (patch rollover)
  - `v0.9.9.X.X` → `v0.10.0.0.0` (minor rollover) 
  - `v0.99.X.X.X` → `v1.0.0.0.0` (major rollover)
- **RESET RULE**: When rolling over, reset all lower numbers to 0

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