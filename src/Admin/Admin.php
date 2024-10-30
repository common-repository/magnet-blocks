<?php

namespace WPMagnetBlocks\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Admin class.
 *
 * @since 1.0.0
 * @package WPMagnetBlocks
 */
class Admin {

	/**
	 * Admin constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'main_menu' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1 );
	}

	/**
	 * Init.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'wpmb-frontend', WPMB_ASSETS_URL . '/css/wpmb-frontend.css', false, '1.0.0' );
	}

	/**
	 * Main menu.
	 *
	 * @since 1.0.0
	 */
	public function main_menu() {
		add_menu_page(
			esc_html__( 'Magnet Blocks', 'magnet-blocks' ),
			esc_html__( 'Magnet Blocks', 'magnet-blocks' ),
			'manage_options',
			'magnet-blocks',
			null,
			'dashicons-grid-view',
			'20'
		);

		add_submenu_page(
			'magnet-blocks',
			esc_html__( 'All Blocks', 'magnet-blocks' ),
			esc_html__( 'All Blocks', 'magnet-blocks' ),
			'manage_options',
			'magnet-blocks',
			array( $this, 'output_all_blocks_settings' )
		);

		add_submenu_page(
			'magnet-blocks',
			esc_html__( 'Settings', 'magnet-blocks' ),
			esc_html__( 'Settings', 'magnet-blocks' ),
			'manage_options',
			'settings',
			array( $this, 'output_settings_page' )
		);
	}

	/**
	 * Output all blocks settings.
	 *
	 * @throws \Exception Throws exception if the request is invalid.
	 *
	 * @since 1.0.0
	 * @return \Exception
	 */
	public function output_all_blocks_settings() {
		try {
			if ( ! empty( $_POST ) && ! check_admin_referer( 'save_blocks' ) ) {
				throw new \Exception( __( 'Error - please try again', 'magnet-blocks' ) );
			}

			if ( isset( $_POST['submit'] ) ) {
				$wpmb_block_title   = isset( $_POST['wpmb_block_title'] ) ? sanitize_text_field( wp_unslash( $_POST['wpmb_block_title'] ) ) : '';
				$wpmb_block_content = isset( $_POST['wpmb_block_content'] ) ? wp_kses_post( wp_unslash( $_POST['wpmb_block_content'] ) ) : '';

				$redirect_to = admin_url( 'admin.php?page=magnet-blocks' );

				if ( ! empty( $wpmb_block_title ) ) {
					update_option( 'wpmb_block_title', $wpmb_block_title );
				}
				if ( ! empty( $wpmb_block_content ) ) {
					update_option( 'wpmb_block_content', $wpmb_block_content );
				}
				wp_safe_redirect( $redirect_to );
				exit();
			}
		} catch ( \Exception $e ) {
			return new \Exception( __( 'Error - please try again', 'magnet-blocks' ) );
		}
		?>
		<h1>
		<?php esc_html_e( 'Plugin Magnet Blocks', 'magnet-blocks' ); ?>
		</h1>
		<p><?php esc_html_e( 'You can manage plugin functionality from here.', 'magnet-blocks' ); ?></p>
		<h3><code><?php echo esc_attr( '[magnet_blocks]' ); ?></code></h3>
		<p><?php esc_html_e( 'Use this shortcode to display this block data', 'magnet-blocks' ); ?></p>
		<form action="" method="post">
			<div class="pev-poststuff" id="wccs-category-showcase">
				<div class="column-1">
					<div class="pev-card">
						<div class="pev-card__header">
							<h3 class="pev-card__title">
								<label for="wpmb_block_title">
									<strong><?php esc_html_e( 'Block title', 'magnet-blocks' ); ?></strong>
								</label>
							</h3>
						</div>
						<div class="pev-card__body form-inline">
							<div class="pev-form-field">
								<input type="text" name="wpmb_block_title" id="wpmb_block_title" class="regular-text" value="<?php echo esc_attr( get_option( 'wpmb_block_title', '' ) ); ?>"/>
								<p><?php esc_html_e( 'Add block title.', 'magnet-blocks' ); ?></p>
							</div>
						</div>
					</div>
					<div class="pev-card">
						<div class="pev-card__header">
							<h3 class="pev-card__title">
								<label for="wpmb_block_content">
									<strong><?php esc_html_e( 'Block content', 'magnet-blocks' ); ?></strong>
								</label>
							</h3>
						</div>
						<div class="pev-card__body form-inline">
							<div class="pev-form-field">
								<?php
								$content   = esc_attr( get_option( 'wpmb_block_content', '' ) );
								$editor_id = 'wpmb_block_content';
								$settings  = array(
									'media_buttons' => true,
									'textarea_rows' => 15,
									'teeny'         => true,
									'textarea_name' => $editor_id,
									'tinymce'       => true,
									'wpautop'       => true,
								);
								wp_editor( $content, $editor_id, $settings );
								?>
								<p><?php esc_html_e( 'Add block content.', 'magnet-blocks' ); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php wp_nonce_field( 'save_blocks' ); ?>
		<?php submit_button( __( 'Save changes', 'magnet-blocks' ) ); ?>
		</form>
		<?php
	}

	/**
	 * Output settings page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function output_settings_page() {
		?>
			<h2><?php esc_html_e( 'Settings page features will coming very soon.', 'magnet-blocks' ); ?></h2>
		<?php
	}
}
