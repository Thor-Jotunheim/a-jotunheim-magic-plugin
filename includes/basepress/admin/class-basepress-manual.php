<?php

// Exit if called directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Basepress_Manual' ) ) {

	class Basepress_Manual {

		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_manual_page' ), 999 );
		}


		public function add_manual_page() {
			add_submenu_page( 'basepress', 'BasePress ' . esc_html__( 'Quick Start Guide', 'basepress' ), esc_html__( 'Quick Start Guide', 'basepress' ), 'manage_options', 'basepress_manual', array( $this, 'display_manual_screen' ) );
		}


		public function display_manual_screen() {
			?>
			<div class="bp-wrap" style="max-width:70em;margin:0 auto">
				<div style="margin:1em 0 0;padding:30px;background-color:#fff;box-shadow:0 1px 1px 0 rgba(0,0,0,.1);">
					<table>
						<tr>
							<td width="100px"><img src="<?php echo esc_url( BASEPRESS_URI ) . 'assets/img/logo.png'; ?>" style="border-radius: 10px;"></td>
							<td><h1 style="font-size: 3em;"><?php esc_html_e( 'Welcome to BasePress', 'basepress' ); ?> <span style="font-size: 0.5em;color:#888;"><?php echo esc_html( BASEPRESS_VER ); ?></span></h1></td>
						</tr>
						<tr>
							<td colspan="2">
								<?php
								if( get_option( 'basepress_run_wizard' ) ){ ?>
									<p>
										<?php esc_html_e( 'Your Knowledge Base is not set up yet. Use the Setup Wizard or go to the settings page to get started manually.', 'basepress' ); ?>
									</p>
									<a class="button button-primary" href="<?php menu_page_url( 'basepress_wizard' ); ?>"><?php esc_html_e( 'Start Wizard', 'basepress' ); ?></a>
									<a class="button" href="<?php echo esc_url( add_query_arg( 'basepress_skip_wizard', 'true', menu_page_url( 'basepress_wizard', false ) ) ); ?>"><?php esc_html_e( 'Settings Page', 'basepress' ); ?></a>
								<?php }	?>
							</td>
						</tr>
					</table>
				</div>
			</div>

			<div class="bp-wrap" style="max-width:70em;margin:0 auto">
				<div style="margin:1em 0 0;padding:30px;background-color:#fff;box-shadow:0 1px 1px 0 rgba(0,0,0,.1);">
					<?php
					$locale = get_user_locale( 0 );
					$file_path = BASEPRESS_DIR . 'assets/manuals/manual-' . $locale . '.html';
					if( file_exists( $file_path ) ){
						include $file_path;
					}
					else{
						include BASEPRESS_DIR . 'assets/manuals/manual.html';
					}

					?>
			</div>
			<?php
		}
	}

	new Basepress_Manual();
}
