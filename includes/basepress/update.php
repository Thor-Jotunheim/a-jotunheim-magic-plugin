<?php
/**
 * Runs Updates from previous versions
 */

function basepress_update( $old_ver, $old_db_ver, $old_plan, $current_ver, $current_db_ver, $current_plan ) {
	global $wpdb;

	if( version_compare( $old_ver, '2.3.2', '<' ) ){
		$wpdb->query("DELETE FROM {$wpdb->termmeta} WHERE {$wpdb->termmeta}.meta_key = 'basepress_restricted_articles'");
	}

	update_option( 'basepress_ver', $current_ver );
	update_option( 'basepress_db_ver', $current_db_ver );
	update_option( 'basepress_plan', $current_plan );

	/**
	 * Sets articles menu_order to zero if on Free version and coming from version < 2.10.1
	 * The menu order was always set incrementally but it is not necessary anymore
	 */
	if( 'lite' == $current_plan && version_compare( $old_ver, '2.10.1', '<' ) ){
		$wpdb->query( "UPDATE {$wpdb->posts} SET menu_order = 0 WHERE {$wpdb->posts}.post_type = 'knowledgebase'" );
	}

	//Update settings if coming from older version or from free to premium
	if ( ! empty( $old_ver )
		&& version_compare( $old_ver, $current_ver, '<' )
		|| ( $old_plan != 'premium' && 'premium' == $current_plan) ) {

		$new_options = array();

		//Upgrade settings from free to premium
		if( ( $old_plan != 'premium' && 'premium' == $current_plan ) ){
			$premium_options = include_once BASEPRESS_DIR . 'premium-options.php';
			$new_options = array_merge( $new_options, $premium_options );
		}
		$new_options = array_merge( $new_options, basepress_update_1_9_0( $old_ver, $current_ver ) );

		$current_options = get_option( 'basepress_settings' );
		foreach ( $new_options as $new_option => $value ) {
			if ( ! isset( $current_options[ $new_option ] ) ) {
				$current_options[ $new_option ] = $value;
			}
		}

		/**
		 * Replace old settings with new ones
		 */
		//Up to version 2.9.2 we had a settings called "order_posts_alphabetically" if it is set we should set the new settings called "posts_orderby"
		if( isset( $current_options['order_posts_alphabetically'] ) ){
			$current_options['posts_orderby'] = 'alpha_asc';
		}
		if( isset( $current_options['kb_name'] ) ){
			$current_options['breadcrumbs_kb_name'] = $current_options['kb_name'];
		}

		update_option( 'basepress_settings', $current_options );

	}

	//Flush rewrite rules on version update for possible changes to CPT
	if( $old_ver != $current_ver && ( is_admin() || current_user_can( 'update_plugins' ) ) && ! wp_doing_ajax() ){
		add_action( 'shutdown', 'basepress_update_flush_rewrite_rules' );
	}
}


function basepress_update_flush_rewrite_rules(){
	flush_rewrite_rules();
}


/**
 * Returns an array of settings for updating to version 1.9.0
 * @param $old_ver
 * @param $current_ver
 * @return array
 */
function basepress_update_1_9_0( $old_ver, $current_ver ) {

	if ( version_compare( $old_ver, '1.9.0', '<' ) ) {
		$new_options = array(
			'show_feedback_form'       => 'always',
			'feedback_form_lable'      => 'Help us improve this article',
			'feedback_submit_text'     => 'Submit Feedback',
			'feedback_submit_success_text' => 'Thanks for your feedback',
			'feedback_submit_fail_text'    => 'There was a problem sending your feedback. Please try again!',
		);
	} else {
		$new_options = array();
	}
	return $new_options;
}

/**
 * Add update notice in Admin and enqueues the necessary JS file
 *
 * @since 1.7.10
 */
function basepress_database_update(){
	add_action( 'admin_notices', 'basepress_update_notice' );
	add_action( 'admin_enqueue_scripts', 'basepress_update_script' );
}

/**
 * Registers the Ajax call for the update notice
 *
 * @since 1.7.10
 */
add_action( 'wp_ajax_basepress_db_posts_update', 'basepress_db_posts_update' );

/**
 * Enqueue update JS file
 *
 * @since 1.7.10
 */
function basepress_update_script(){
	wp_register_script( 'basepress-update-script', BASEPRESS_URI . 'admin/js/basepress-update-script.js', array('jquery'), BASEPRESS_VER, true );
	$params = array(
		'nonce' => wp_create_nonce( 'update_nonce' ),
	);
	wp_localize_script( 'basepress-update-script', 'update', $params );
	wp_enqueue_script( 'basepress-update-script' );
}

/**
 * Display admin notice to update DB
 *
 * @since 1.7.10
 */
function basepress_update_notice(){
	?>
	<div id="basepress-db-update-notice" class="notice notice-error">
		<p>
			<span style="font-size: 1.2em; font-weight: bold;">BasePress </span>
			<span id="basepress-notice-text"><?php echo esc_html__( 'needs to update your database to take full advantage of its features!', 'basepress' ); ?></span>
			<span id="basepress-notice-success"><?php echo esc_html__( 'your database has been updated!', 'basepress' ); ?></span>
			<button id="basepress-update-db" class="button button-primary" style="margin-left:2em"><span id="basepress-update-spinner" class="dashicons dashicons-update"></span> <?php echo esc_html__( 'Update Database', 'basepress' ); ?></button>
		</p>
	</div>
	<style>
		#basepress-notice-success{
			display: none;
		}
		#basepress-update-spinner{
			line-height: inherit;
		}
		#basepress-update-spinner.spinning:before{
			display: block;
			animation: bp-spinner 1500ms infinite linear;
		}
		@keyframes bp-spinner{
			from{ transform: rotate(0);}
			to{ transform: rotate(359.99deg);}
		}
	</style>
	<?php
}



/**
 * Main Ajax call function for DB update
 *
 * @since 1.7.10
 */
function basepress_db_posts_update(){

	header('Content-Type: application/json');

	check_ajax_referer( 'update_nonce', 'security' );
	if ( ! current_user_can( 'update_plugins' ) ) {
		wp_die();
	}
	$process = sanitize_text_field( wp_unslash( $_POST['process'] ) );
	$data = sanitize_text_field( wp_unslash( $_POST['packet'] ) );
	$transient = sanitize_text_field( wp_unslash( $_POST['transient'] ) );
	$saved_transient = get_transient( 'basepress_db_update_started' );

	if( $saved_transient && $saved_transient != $transient ){
		echo json_encode('The update is already running!');
	}
	else{

		switch( $process ){
			case 'get_update_objects':
				$items_query = new WP_Query(
					array( 'post_type'      => 'knowledgebase',
					       'posts_per_page' => -1,
					       'fields'         => 'ids',
					)
				);

				$transient = sprintf( '%.22F', microtime( true ) );
				set_transient( 'basepress_db_update_started', $transient, 350 );
				echo wp_json_encode( array( 'items' => $items_query->posts, 'transient' => $transient ) );

				break;
			case 'update_items':
				if( $saved_transient == $transient ){
					basepress_updates_process_post_data( $data, $transient );
				}
				else{
					echo json_encode('There was a problem with the update. Please retry.');
					delete_transient( 'basepress_db_update_started' );
				}
				break;
			case 'process_finished':
				delete_transient( 'basepress_db_update_started' );
				update_site_option( 'basepress_db_ver', 2.1 );
		}
	}
	wp_die();
}

/**
 * Processes the passed IDs updating the postmeta in the DB
 * Called by the main Ajax function basepress_db_posts_update()
 *
 * @since 1.7.10
 *
 * @param $post_ids
 */
function basepress_updates_process_post_data( $post_ids ){
	header('Content-Type: application/json');

	$processed_items = array();

	foreach( $post_ids as $post_id ){
		//Get all meta for the post
		$post_meta = get_post_meta( $post_id );

		$votes = isset( $post_meta['basepress_votes'] ) ? maybe_unserialize( $post_meta['basepress_votes'][0] ) : array();
		$votes = isset( $votes['like'] ) && isset( $votes['dislike'] ) ? $votes : array( 'like'=> 0, 'dislike'=> 0 );

		//Set votes count
		$votes_count = $votes['like'] + $votes['dislike'];

		//Generate the score for the current post id
		if( $votes['like'] > $votes['dislike'] ){
			$score = round( ( $votes['like'] / ( $votes['like'] + $votes['dislike'] ) ) * 100 );
		}else if( $votes['like'] < $votes['dislike'] ){
			$score = -round( ( $votes['dislike'] / ( $votes['like'] + $votes['dislike'] ) ) * 100 );
		}else{
			$score = 0;
		}

		update_post_meta( $post_id, 'basepress_votes', $votes );
		update_post_meta( $post_id, 'basepress_votes_count', $votes_count );
		update_post_meta( $post_id, 'basepress_score', $score );

		$processed_items[] = $post_id;
	}
	echo wp_json_encode( $processed_items );
	wp_die();
}
