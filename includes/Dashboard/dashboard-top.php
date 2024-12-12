<?php
// Add custom admin bar menus
add_action('admin_bar_menu', function ($wp_admin_bar) {
    if (!is_user_logged_in()) {
        return;
    }

    // Get current user roles
    $user = wp_get_current_user();
    $roles = $user->roles;

    // Add Admin Magic menu for Editor role and above
    if (in_array('editor', $roles) || in_array('administrator', $roles)) {
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

    // Add Moderator Magic menu for Moderator role and above
    if (in_array('moderator', $roles) || in_array('administrator', $roles)) {
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
    // Remove Gutenverse sections
    $wp_admin_bar->remove_node('gutenverse');
    $wp_admin_bar->remove_node('gutenverse-pro');
    $wp_admin_bar->remove_node('upgrade-plus');
}, 999);