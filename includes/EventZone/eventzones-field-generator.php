<?php
// File: eventzones-field-generator.php

class EventZoneFieldGenerator {
    
    /**
     * Generate form fields based on database columns and custom configurations
     */
    public static function generateFormFields($columns = null, $zone_data = null, $form_id = 'add-new-zone-form') {
        global $wpdb;
        
        // If no columns provided, fetch fresh from database
        if ($columns === null) {
            $table_name = 'jotun_eventzones';
            $columns = $wpdb->get_results("DESCRIBE $table_name");
        }
        
        $field_configs = get_option('jotunheim_eventzone_field_config', []);
        $html = '';
        $processed_fields = [];
        
        // Create array of actual database column names for validation
        $db_columns = [];
        foreach ($columns as $column) {
            $field_name = is_object($column) ? $column->Field : $column;
            $db_columns[] = $field_name;
        }
        
        // Clean up orphaned field configurations (configs for deleted columns)
        $cleaned_configs = [];
        foreach ($field_configs as $config_field => $config) {
            if (in_array($config_field, $db_columns)) {
                $cleaned_configs[$config_field] = $config;
            }
        }
        
        // Update the saved configurations if we cleaned any orphaned ones
        if (count($cleaned_configs) !== count($field_configs)) {
            update_option('jotunheim_eventzone_field_config', $cleaned_configs);
            $field_configs = $cleaned_configs;
        }
        
        // Process all database columns - no more separate custom field handling
        foreach ($columns as $column) {
            $field_name = is_object($column) ? $column->Field : $column;
            $field_type = is_object($column) ? $column->Type : '';
            
            // Skip 'id' and 'string_name' fields
            if (in_array($field_name, ['id', 'string_name'])) continue;
            
            // Double-check that this field exists in zone_data if provided
            if ($zone_data && !array_key_exists($field_name, $zone_data)) {
                error_log("EventZone field generator: Field '$field_name' not found in zone data, skipping");
                continue;
            }
            
            // Get custom configuration or use defaults
            $config = isset($field_configs[$field_name]) ? $field_configs[$field_name] : self::getDefaultFieldConfig($field_name, $field_type);
            
            // Generate field HTML
            $html .= self::generateSingleField($field_name, $config, $zone_data, $form_id);
            $processed_fields[] = $field_name;
        }
        
        return $html;
    }
    
    /**
     * Generate a single field based on configuration
     */
    private static function generateSingleField($field_name, $config, $zone_data = null, $form_id = 'add-new-zone-form') {
        $field_value = $zone_data ? ($zone_data[$field_name] ?? '') : '';
        $label = $config['label'] ?: ucfirst(str_replace('_', ' ', $field_name));
        $placeholder = $config['placeholder'] ?? '';
        
        // Determine if field should be conditionally hidden
        $conditional_class = '';
        $conditional_data = '';
        if ($config['is_conditional']) {
            $conditional_class = 'conditional-field';
            
            // Handle multiple conditions (new format)
            if (isset($config['conditions']) && !empty($config['conditions'])) {
                $conditions_json = json_encode($config['conditions']);
                $conditional_data = 'data-conditions="' . esc_attr($conditions_json) . '"';
            }
            // Fallback to old format for backward compatibility
            elseif (isset($config['conditional_field']) && isset($config['conditional_value'])) {
                $conditional_data = 'data-conditional-field="' . esc_attr($config['conditional_field']) . '" data-conditional-value="' . esc_attr($config['conditional_value']) . '"';
            }
        }
        
        $html = "<div class='field-row $conditional_class' style='display: flex; align-items: center; margin-bottom: 10px;' data-field='$field_name' $conditional_data>";
        $html .= "<label for='$field_name' style='flex: 1; font-weight: bold;'>$label:</label>";
        $html .= "<div style='flex: 2;'>";
        
        switch ($config['type']) {
            case 'checkbox':
                $checked = ($field_value == 1) ? 'checked' : '';
                $html .= "<input type='hidden' name='$field_name' value='0'>";
                $html .= "<input type='checkbox' id='$field_name' name='$field_name' value='1' $checked style='transform: scale(1.2); margin-top: 5px;'>";
                break;
                
            case 'dropdown':
                $html .= "<select id='$field_name' name='$field_name' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>";
                $options = explode("\n", $config['dropdown_options']);
                foreach ($options as $option) {
                    $option = trim($option);
                    if ($option) {
                        $selected = ($field_value == $option) ? 'selected' : '';
                        $html .= "<option value='" . esc_attr($option) . "' $selected>" . esc_html($option) . "</option>";
                    }
                }
                $html .= "</select>";
                break;
                
            case 'textarea':
                $html .= "<textarea id='$field_name' name='$field_name' rows='4' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%; resize: vertical;' placeholder='" . esc_attr($placeholder) . "'>" . esc_textarea($field_value) . "</textarea>";
                break;
                
            case 'number':
                $html .= "<input type='number' id='$field_name' name='$field_name' value='" . esc_attr($field_value) . "' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;' placeholder='" . esc_attr($placeholder) . "'>";
                break;
                
            case 'text':
            default:
                $html .= "<input type='text' id='$field_name' name='$field_name' value='" . esc_attr($field_value) . "' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;' placeholder='" . esc_attr($placeholder) . "'>";
                break;
        }
        
        $html .= "</div></div>";
        return $html;
    }
    
    /**
     * Get default field configuration based on field name and database type
     */
    private static function getDefaultFieldConfig($field_name, $field_type) {
        // Default configurations for specific known fields
        $defaults = [
            'shape' => [
                'type' => 'dropdown',
                'label' => 'Shape',
                'placeholder' => '',
                'dropdown_options' => "Circle\nSquare",
                'is_conditional' => false,
                'conditional_field' => '',
                'conditional_value' => ''
            ],
            'eventzone_status' => [
                'type' => 'dropdown',
                'label' => 'Status',
                'placeholder' => '',
                'dropdown_options' => "enabled\ndisabled",
                'is_conditional' => false,
                'conditional_field' => '',
                'conditional_value' => ''
            ],
            'zone_type' => [
                'type' => 'dropdown',
                'label' => 'Zone Type',
                'placeholder' => '',
                'dropdown_options' => "Server Infrastructure\nQuest\nEvent\nBoss Power\nBoss Fight\nNPC",
                'is_conditional' => false,
                'conditional_field' => '',
                'conditional_value' => ''
            ],
            'name' => [
                'type' => 'text',
                'label' => 'Name',
                'placeholder' => 'eventZoneName',
                'dropdown_options' => '',
                'is_conditional' => false,
                'conditional_field' => '',
                'conditional_value' => ''
            ],
            'priority' => [
                'type' => 'number',
                'label' => 'Priority',
                'placeholder' => '10',
                'dropdown_options' => '',
                'is_conditional' => false,
                'conditional_field' => '',
                'conditional_value' => ''
            ],
            'position' => [
                'type' => 'text',
                'label' => 'Position',
                'placeholder' => '0,0,0',
                'dropdown_options' => '',
                'is_conditional' => false,
                'conditional_field' => '',
                'conditional_value' => ''
            ],
            'respawnLocation' => [
                'type' => 'text',
                'label' => 'Respawn Location',
                'placeholder' => '0,0,0',
                'dropdown_options' => '',
                'is_conditional' => true,
                'conditional_field' => 'respawnAtLocation',
                'conditional_value' => '1'
            ],
            'radius' => [
                'type' => 'number',
                'label' => 'Radius',
                'placeholder' => '20',
                'dropdown_options' => '',
                'is_conditional' => false,
                'conditional_field' => '',
                'conditional_value' => ''
            ],
            'squareXRadius' => [
                'type' => 'number',
                'label' => 'Square X Radius',
                'placeholder' => '20',
                'dropdown_options' => '',
                'is_conditional' => true,
                'conditional_field' => 'shape',
                'conditional_value' => 'Square'
            ],
            'squareZRadius' => [
                'type' => 'number',
                'label' => 'Square Z Radius',
                'placeholder' => '20',
                'dropdown_options' => '',
                'is_conditional' => true,
                'conditional_field' => 'shape',
                'conditional_value' => 'Square'
            ]
        ];
        
        if (isset($defaults[$field_name])) {
            return $defaults[$field_name];
        }
        
        // Auto-detect based on database field type
        if (strpos($field_type, 'tinyint(1)') !== false) {
            return [
                'type' => 'checkbox',
                'label' => '',
                'placeholder' => '',
                'dropdown_options' => '',
                'is_conditional' => false,
                'conditional_field' => '',
                'conditional_value' => ''
            ];
        } elseif (strpos($field_type, 'int') !== false) {
            return [
                'type' => 'number',
                'label' => '',
                'placeholder' => '',
                'dropdown_options' => '',
                'is_conditional' => false,
                'conditional_field' => '',
                'conditional_value' => ''
            ];
        } elseif (strpos($field_type, 'text') !== false) {
            return [
                'type' => 'textarea',
                'label' => '',
                'placeholder' => '',
                'dropdown_options' => '',
                'is_conditional' => false,
                'conditional_field' => '',
                'conditional_value' => ''
            ];
        } else {
            return [
                'type' => 'text',
                'label' => '',
                'placeholder' => '',
                'dropdown_options' => '',
                'is_conditional' => false,
                'conditional_field' => '',
                'conditional_value' => ''
            ];
        }
    }
    
    /**
     * Generate JavaScript for conditional field handling
     */
    public static function generateConditionalFieldsJS() {
        $field_configs = get_option('jotunheim_eventzone_field_config', []);
        $js = "";
        
        foreach ($field_configs as $field_name => $config) {
            if ($config['is_conditional']) {
                // Handle multiple conditions (new format)
                if (isset($config['conditions']) && !empty($config['conditions'])) {
                    $conditions = $config['conditions'];
                    $watchFields = [];
                    $conditionChecks = [];
                    
                    foreach ($conditions as $condition) {
                        $watchFields[] = '#' . $condition['field'];
                        // Handle both checkboxes and other field types
                        $conditionChecks[] = "(function() { 
                            var field = $('#{$condition['field']}'); 
                            if (field.is(':checkbox')) {
                                return field.is(':checked') && '{$condition['value']}' === '1';
                            } else {
                                return field.val() === '{$condition['value']}';
                            }
                        })()";
                    }
                    
                    $watchFieldsStr = implode(', ', array_unique($watchFields));
                    $conditionLogic = implode(' || ', $conditionChecks);
                    
                    $js .= "
                    // Handle conditional display for {$field_name} (multiple conditions)
                    $('{$watchFieldsStr}').on('change input', function() {
                        var isMatched = {$conditionLogic};
                        $('[data-field=\"{$field_name}\"]').toggle(isMatched);
                    });
                    
                    // Initialize conditional field visibility for {$field_name}
                    $(document).ready(function() {
                        var {$field_name}_isMatched = {$conditionLogic};
                        $('[data-field=\"{$field_name}\"]').toggle({$field_name}_isMatched);
                    });
                    ";
                }
                // Fallback to old format for backward compatibility
                elseif (isset($config['conditional_field']) && isset($config['conditional_value'])) {
                    $js .= "
                    // Handle conditional display for {$field_name} (legacy single condition)
                    $('#{$config['conditional_field']}').on('change input', function() {
                        var isMatched;
                        if ($(this).is(':checkbox')) {
                            isMatched = $(this).is(':checked') && '{$config['conditional_value']}' === '1';
                        } else {
                            isMatched = $(this).val() === '{$config['conditional_value']}';
                        }
                        $('[data-field=\"{$field_name}\"]').toggle(isMatched);
                    });
                    
                    // Initialize conditional field visibility for {$field_name}
                    $(document).ready(function() {
                        var field = $('#{$config['conditional_field']}');
                        var {$field_name}_isMatched;
                        if (field.is(':checkbox')) {
                            {$field_name}_isMatched = field.is(':checked') && '{$config['conditional_value']}' === '1';
                        } else {
                            {$field_name}_isMatched = field.val() === '{$config['conditional_value']}';
                        }
                        $('[data-field=\"{$field_name}\"]').toggle({$field_name}_isMatched);
                    });
                    ";
                }
            }
        }
        
        return $js;
    }
}
?>
