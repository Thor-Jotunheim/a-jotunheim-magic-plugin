<?php

if ( ! wp_next_scheduled( 'jotun_daily_cleanup' ) ) {
    wp_schedule_event( time(), 'daily', 'jotun_daily_cleanup' );
}

add_action( 'jotun_daily_cleanup', 'jotun_delete_inactive_shops' );

function jotun_delete_inactive_shops() {
    global $wpdb;

    $wpdb->query("
        DELETE jotun_shop_items
        FROM jotun_shop_items
        INNER JOIN jotun_shops ON jotun_shop_items.shop_id = jotun_shops.shop_id
        LEFT JOIN jotun_transactions ON jotun_shops.shop_id = jotun_transactions.shop_id
        AND jotun_transactions.transaction_date > NOW() - INTERVAL 30 DAY
        WHERE jotun_transactions.shop_id IS NULL
    ");

    $wpdb->query("
        DELETE jotun_shops
        FROM jotun_shops
        LEFT JOIN jotun_transactions ON jotun_shops.shop_id = jotun_transactions.shop_id
        AND jotun_transactions.transaction_date > NOW() - INTERVAL 30 DAY
        WHERE jotun_transactions.shop_id IS NULL
    ");
}
