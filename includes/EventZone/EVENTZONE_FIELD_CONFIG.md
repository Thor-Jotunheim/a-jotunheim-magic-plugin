# EventZone Field Configuration System

This system allows you to easily configure how fields appear in the EventZone add/edit interfaces without having to edit code directly.

## How to Use

1. **Access the Configuration**: Go to WordPress Admin → Jotunheim Magic → EventZone Field Config
2. **Add Field Configurations**: Use the form to configure how database fields should appear in the interfaces
3. **Field Types Available**:
   - **Text Input**: Regular text input field
   - **Checkbox**: Boolean checkbox field 
   - **Dropdown**: Select dropdown with custom options
   - **Textarea**: Multi-line text area
   - **Number Input**: Numeric input field

## Field Configuration Options

### Basic Settings
- **Field Name**: Select a database field from the dropdown
- **Field Type**: Choose how the field should be displayed (text, checkbox, dropdown, etc.)
- **Display Label**: Custom label to show (leave empty to auto-generate)
- **Placeholder Text**: Placeholder text for text/number inputs
- **Dropdown Options**: One option per line for dropdown fields

### Conditional Display
- **Conditional Display**: Show field only when another field matches a specific value
- **Show When**: Choose the controlling field and the value that triggers visibility

## Examples

### Adding a New Checkbox Field
1. Field Name: `newBooleanField`
2. Field Type: `Checkbox`
3. Display Label: `Enable Special Feature`

### Adding a Conditional Field
1. Field Name: `specialRadius`
2. Field Type: `Number Input`
3. Display Label: `Special Radius`
4. Conditional Display: ✓ Checked
5. Show When: `shape` equals `Circle`

This field will only show when the shape is set to "Circle".

### Adding a Dropdown Field
1. Field Name: `difficulty`
2. Field Type: `Dropdown`
3. Display Label: `Difficulty Level`
4. Dropdown Options:
   ```
   Easy
   Medium
   Hard
   Nightmare
   ```

## Default Configurations

The system includes default configurations for existing fields:
- `shape`: Dropdown (Circle/Square)
- `eventzone_status`: Dropdown (enabled/disabled)
- `zone_type`: Dropdown (Server Infrastructure, Quest, Event, etc.)
- Respawn-related fields have conditional visibility
- Square radius fields show only when shape is "Square"

## Benefits

1. **No Code Editing**: Add new field types without touching interface files
2. **Conditional Logic**: Show/hide fields based on other field values
3. **Consistent UI**: All fields use the same styling and behavior
4. **Future-Proof**: Easy to add new field types as your database evolves

## Database Fields Reference

The configuration page shows all available database fields from the `jotun_eventzones` table. Fields with a ✓ already have custom configurations.

## Technical Details

- Field configurations are stored in WordPress options table as `jotunheim_eventzone_field_config`
- The `EventZoneFieldGenerator` class handles field generation and conditional logic
- Both Add New and Edit interfaces use the same field generation system
- JavaScript is automatically generated for conditional field behavior
