<?php
// Add custom admin bar menus
add_action('admin_bar_menu', function ($wp_admin_bar) {
    if (!is_user_logged_in()) {
        return;
    }

    // Get current user roles
    $user = wp_get_current_user();
    $roles = $user->roles;

    // Ensure both Editor and Administrator roles can access Admin Magic
    if (array_intersect($roles, ['administrator', 'editor'])) {
        $wp_admin_bar->add_node([
            'id'    => 'admin-magic',
            'title' => 'Admin Magic',
            'href'  => '#', // Replace with a relevant link if needed
            'meta'  => [
                'class' => 'admin-magic-menu',
            ],
        ]);

        // Add Item List Editor submenu
        $wp_admin_bar->add_node([
            'id'     => 'item-list-editor',
            'parent' => 'admin-magic',
            'title'  => 'Item List Editor',
            'href'   => admin_url('admin.php?page=item_list_editor'),
        ]);

        // Add Item List Add New submenu
        $wp_admin_bar->add_node([
            'id'     => 'item-list-add-new',
            'parent' => 'admin-magic',
            'title'  => 'Item List Add New Item',
            'href'   => admin_url('admin.php?page=item_list_add_new_item'),
        ]);

        // Add Event Zone Editor submenu
        $wp_admin_bar->add_node([
            'id'     => 'event-zone-editor',
            'parent' => 'admin-magic',
            'title'  => 'Event Zone Editor',
            'href'   => admin_url('admin.php?page=event_zone_editor'),
        ]);

        // Add Event Zone Add New submenu
        $wp_admin_bar->add_node([
            'id'     => 'event-zone-add-new',
            'parent' => 'admin-magic',
            'title'  => 'Event Zone Add New',
            'href'   => admin_url('admin.php?page=add_event_zone'),
        ]);

        // Add Weather Calendar Config submenu
        $wp_admin_bar->add_node([
            'id'     => 'weather-calendar-config',
            'parent' => 'admin-magic',
            'title'  => 'Weather Calendar Config',
            'href'   => admin_url('admin.php?page=weather_calendar_config'),
        ]);

        // Add EventZone Field Config submenu
        $wp_admin_bar->add_node([
            'id'     => 'eventzone-field-config',
            'parent' => 'admin-magic',
            'title'  => 'EventZone Field Config',
            'href'   => admin_url('admin.php?page=eventzone_field_config'),
        ]);
    }

    // Ensure Administrator, Editor, and Moderator roles can access Moderator Magic
    if (array_intersect($roles, ['administrator', 'editor', 'moderator'])) {
        $wp_admin_bar->add_node([
            'id'    => 'moderator-magic',
            'title' => 'Moderator Magic',
            'href'  => '#', // Replace with a relevant link if needed
            'meta'  => [
                'class' => 'moderator-magic-menu',
            ],
        ]);

        // Add a placeholder submenu for Moderator Magic
        $wp_admin_bar->add_node([
            'id'     => 'moderator-placeholder',
            'parent' => 'moderator-magic',
            'title'  => 'Placeholder',
            'href'   => '#',
        ]);
    }

    // Add Knowledge Base access for wiki_editor role
    if (in_array('wiki_editor', $roles)) {
        // Add Knowledge Base menu for wiki editors
        $wp_admin_bar->add_node([
            'id'    => 'wiki-editor-kb',
            'title' => 'Knowledge Base',
            'href'  => admin_url('edit.php?post_type=knowledgebase'), // Adjust post type if needed
            'meta'  => [
                'class' => 'wiki-editor-kb-menu',
            ],
        ]);
        
        // Add KB options exactly as shown in the screenshot
        $wp_admin_bar->add_node([
            'id'     => 'wiki-editor-kb-all',
            'parent' => 'wiki-editor-kb',
            'title'  => 'All Articles',
            'href'   => admin_url('edit.php?post_type=knowledgebase'),
        ]);
        
        $wp_admin_bar->add_node([
            'id'     => 'wiki-editor-kb-add',
            'parent' => 'wiki-editor-kb',
            'title'  => 'Add Post',
            'href'   => admin_url('post-new.php?post_type=knowledgebase'),
        ]);
        
        //$wp_admin_bar->add_node([
        //    'id'     => 'wiki-editor-kb-manage',
        //    'parent' => 'wiki-editor-kb',
        //    'title'  => 'Manage KBs',
        //    'href'   => admin_url('edit.php?post_type=knowledgebase&page=basepress_manage_kbs'),
        //]);
        
        $wp_admin_bar->add_node([
            'id'     => 'wiki-editor-kb-sections',
            'parent' => 'wiki-editor-kb',
            'title'  => 'Sections',
            'href'   => admin_url('edit.php?post_type=knowledgebase&page=basepress_sections'),
        ]);
    }
}, 100);

// Hide unwanted sections in the admin bar
add_action('wp_after_admin_bar_render', function () {
    global $wp_admin_bar;

    // Remove specific nodes by their exact IDs
    $nodes_to_remove = [
        'gutenverse',            // Gutenverse
        'gutenverse-pro',        // Gutenverse PRO
        'updraft_admin_node',    // UpdraftPlus
    ];
    
    // Remove New+ dropdown for wiki editors
    if (current_user_can('wiki_editor') && !current_user_can('administrator')) {
        $nodes_to_remove[] = 'new-content';
        $nodes_to_remove[] = 'new-post';
        $nodes_to_remove[] = 'new-media';
        $nodes_to_remove[] = 'new-page';
        $nodes_to_remove[] = 'new-user';
    }

    foreach ($nodes_to_remove as $node_id) {
        $wp_admin_bar->remove_node($node_id);
    }
}, PHP_INT_MAX); // Ensures this runs very late

// Enforce hiding unwanted sections with CSS
add_action('admin_head', function () {
    if (current_user_can('wiki_editor') && !current_user_can('administrator')) {
        echo '<style>
            #wp-admin-bar-gutenverse,
            #wp-admin-bar-gutenverse-pro,
            #wp-admin-bar-updraft_admin_node,
            #wp-admin-bar-new-content,
            #wp-admin-bar-new-post,
            #wp-admin-bar-new-media,
            #wp-admin-bar-new-page,
            #wp-admin-bar-new-user {
                display: none !important;
            }
        </style>';
    } else {
        echo '<style>
            #wp-admin-bar-gutenverse,
            #wp-admin-bar-gutenverse-pro,
            #wp-admin-bar-updraft_admin_node {
                display: none !important;
            }
        </style>';
    }
});