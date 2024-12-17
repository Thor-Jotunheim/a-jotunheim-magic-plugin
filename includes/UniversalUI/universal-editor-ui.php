<?php
function jotunheim_magic_universal_editor_interface() {
    global $wpdb;

    // Fetch tables dynamically
    $tables = jotunheim_get_enabled_universal_ui_tables();

    ob_start(); ?>
    <div class="wrap universal-editor-container" style="width: 100%; max-width: 1000px; margin: auto; background: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.bhmpics.com%2Fdownloads%2FValheim-Wallpapers%2F77.3-mistlands-teaser-1bb74b243f7219098476.jpg&f=1&nofb=1&ipt=45065e8b7cc5ca3ae8824364501250a2b5b4cf1428e93cd817bd8671ce697ec2&ipo=images') no-repeat fixed center; background-size: cover; padding: 5px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); overflow: hidden; display: flex; gap: 20px; height: auto; min-height: calc(110vh - 50px);">
        
        <!-- Left Section: Table and Records -->
        <div style="flex: 1; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
            <h3 style="text-align: center; margin-bottom: 10px;">Select Table</h3>
            <select id="table-selector" style="width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 5px;">
                <option value="">-- Select a Table --</option>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo esc_attr($table); ?>"><?php echo esc_html($table); ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Records List -->
            <div class="wrap record-editor-container" id="record-editor-container" style="width: 100%; max-width: 1000px; margin: auto; background: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.bhmpics.com%2Fdownloads%2FValheim-Wallpapers%2F77.3-mistlands-teaser-1bb74b243f7219098476.jpg&f=1&nofb=1&ipt=45065e8b7cc5ca3ae8824364501250a2b5b4cf1428e93cd817bd8671ce697ec2&ipo=images') no-repeat fixed center; background-size: cover; padding: 5px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); overflow: hidden; display: flex; gap: 20px; height: auto; min-height: calc(110vh - 50px);">
        
        <div style="flex: 1; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
            <h1 class="record-title" style="font-family: 'MedievalSharp', cursive; font-size: 36px; color: #fff; text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7); text-align: center;">Jotunheim Universal Record Editor</h1>
            <div class="search-section" style="margin-bottom: 5px;">
                <input type="text" id="record-search" placeholder="Search for a record..." style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666; font-size: 16px;">
                <button id="load-record-btn" style="width: 100%; background: #444; color: #fff; padding: 12px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 10px;">Load Selected Zones</button>
                <button id="clear-record-btn" style="width: 100%; background: #888; color: #fff; padding: 12px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 10px; margin-bottom: 10px;">Clear Selected</button>
                <div id="universal-editor-container" style="height: auto; max-height: calc(90vh - 140px); overflow-y: auto; background: rgba(255, 255, 255, 0.9); padding: 10px; border-radius: 5px;">
                    <!-- Dynamically added checkboxes for records -->
                </div>
            </div>
        </div>

        <div style="flex: 2; overflow-y: auto; height: auto; min-height: calc(110vh - 50px);">
            <div id="edit-sections-container" class="edit-section" style="background: rgba(255, 255, 255, 0.7); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
                <h3 style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #222; text-align: center;">Edit Record Details</h3>
                <!-- Edit sections will be dynamically added here -->
            </div>
        </div>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('universal_editor_ui', 'jotunheim_magic_universal_editor_interface');
?>