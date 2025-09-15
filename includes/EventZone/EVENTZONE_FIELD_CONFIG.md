# EventZone Field Configuration System

This system allows you to easily configure how fields appear in the EventZone add/edit interfaces without having to edit code directly. You can configure **existing database fields** AND **add completely new custom fields**.

## How to Use

1. **Access the Configuration**: Go to WordPress Admin → Jotunheim Magic → EventZone Field Config
2. **Choose Field Source**: 
   - **Configure Existing Database Field**: Select from existing fields in your database
   - **Add New Custom Field**: Create entirely new fields that don't exist in the database
3. **Configure Field Properties**: Set the field type, label, placeholder, etc.
4. **Set Conditional Logic**: Make fields show/hide based on other field values

## Field Types Available
- **Text Input**: Regular text input field
- **Checkbox**: Boolean checkbox field 
- **Dropdown**: Select dropdown with custom options
- **Textarea**: Multi-line text area
- **Number Input**: Numeric input field

## Field Sources

### Existing Database Fields
Configure how existing database columns appear in the interface:
- Select from dropdown of available database fields
- Fields that already have configurations won't appear in the list
- Perfect for changing how existing fields are displayed

### Custom Fields (NEW!)
Add completely new fields that don't exist in the database:
- Enter a custom field name (use lowercase, underscores only)
- These fields will appear in your interfaces but won't be saved to database (unless you add the column later)
- Great for frontend-only fields, calculated fields, or temporary fields

## Field Configuration Options

### Basic Settings
- **Field Source**: Choose between existing database field or new custom field
- **Field Name**: Database field name or custom field name
- **Field Input Type**: How the field should be displayed (text, checkbox, dropdown, etc.)
- **Display Label**: Custom label to show (leave empty to auto-generate)
- **Placeholder Text**: Placeholder text for text/number inputs
- **Dropdown Options**: One option per line for dropdown fields

### Conditional Display
- **Conditional Display**: Show field only when another field matches a specific value
- **Show When**: Choose the controlling field (database or custom) and the value that triggers visibility

## Examples

### Configuring an Existing Database Field
1. Field Source: ✓ Configure Existing Database Field
2. Field Name: `radius` (from dropdown)
3. Field Input Type: `Number Input`
4. Display Label: `Zone Radius (meters)`
5. Placeholder Text: `20`

### Adding a New Custom Field
1. Field Source: ✓ Add New Custom Field
2. Custom Field Name: `special_effect`
3. Field Input Type: `Dropdown`
4. Display Label: `Special Effect`
5. Dropdown Options:
   ```
   None
   Fire
   Ice
   Lightning
   Poison
   ```

### Adding a Conditional Custom Field
1. Field Source: ✓ Add New Custom Field
2. Custom Field Name: `fire_damage`
3. Field Input Type: `Number Input`
4. Display Label: `Fire Damage Per Second`
5. Conditional Display: ✓ Checked
6. Show When: `special_effect` equals `Fire`

This field will only show when the special effect is set to "Fire".

## Interface Updates

The configuration interface now shows:
- **Source Column**: Whether each field is from Database, Custom, or Unknown
- **Fields Reference Section**: Shows both database fields and custom fields separately
- **Enhanced Conditional Field Selection**: Includes both database and custom fields in conditional dropdown
- **Better Validation**: Ensures custom field names follow proper naming conventions

## Benefits

1. **No Code Editing**: Add new field types without touching interface files
2. **Complete Flexibility**: Add both database-backed and custom frontend-only fields
3. **Conditional Logic**: Show/hide fields based on other field values (works with both types)
4. **Consistent UI**: All fields use the same styling and behavior
5. **Future-Proof**: Easy to add new field types as your needs evolve
6. **Visual Distinction**: Custom fields are clearly marked and styled differently

## Technical Notes

- **Database Fields**: Must exist in the `jotun_eventzones` table
- **Custom Fields**: Stored only in configuration, not in database (unless you add the column later)
- **Storage**: Field configurations saved in WordPress options as `jotunheim_eventzone_field_config`
- **JavaScript**: Automatically handles conditional logic for both field types
- **Validation**: Custom field names must start with letter, use only lowercase, numbers, and underscores

## Migration Path

If you create a custom field and later want to add it to the database:
1. Add the column to your `jotun_eventzones` table
2. The field will automatically be recognized as a database field
3. No configuration changes needed - it will continue working seamlessly
