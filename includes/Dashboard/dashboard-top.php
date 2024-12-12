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
            'href'   => admin_url('admin.php?page=itemlist-editor'), // Replace with the actual link
        ]);

        // Add Item List Add New submenu
        $wp_admin_bar->add_node([
            'id'     => 'item-list-add-new',
            'parent' => 'admin-magic',
            'title'  => 'Item List Add New Item',
            'href'   => admin_url('admin.php?page=itemlist-add-new'), // Replace with the actual link
        ]);

        // Add Event Zone Editor submenu
        $wp_admin_bar->add_node([
            'id'     => 'event-zone-editor',
            'parent' => 'admin-magic',
            'title'  => 'Event Zone Editor',
            'href'   => admin_url('admin.php?page=eventzone-editor'), // Replace with the actual link
        ]);
    }

    // Ensure both Moderator and Administrator roles can access Moderator Magic
    if (array_intersect($roles, ['administrator', 'moderator'])) {
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
}, 100);

// Hide unwanted sections in the admin bar
add_action('admin_bar_menu', function ($wp_admin_bar) {
    // Remove specific nodes from the admin bar
    $nodes_to_remove = [
        'gutenverse',       // Gutenverse
        'gutenverse-pro',   // Gutenverse PRO
        'upgrade-plus',     // UpgradePlus
        'updraft_admin_node' // UpdraftPlus (adjust if different ID)
    ];

    foreach ($nodes_to_remove as $node_id) {
        $wp_admin_bar->remove_node($node_id);
    }
}, 999);