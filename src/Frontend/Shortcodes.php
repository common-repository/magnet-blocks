<?php

namespace WPMagnetBlocks\Frontend;

defined( 'ABSPATH' ) || exit;

/**
 * Shortcodes class.
 *
 * @since 1.0.0
 * @package WPMagnetBlocks
 */
class Shortcodes {
	/**
	 * Shortcodes constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_shortcode( 'magnet_blocks', array( $this, 'shortcode_render_callback' ) );
	}

	/**
	 * Magnet Blocks shortcode render callback.
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	public function shortcode_render_callback() {
		$title   = get_option( 'wpmb_block_title', '' );
		$content = get_option( 'wpmb_block_content', '' );

		if ( empty( $title ) || empty( $content ) ) {
			return '';
		}

		return '<div class="wpmb-block-wrapper">
            <div class="wpmb-block">
                <div class="wpmb-block-header">
                    <h1>' . esc_attr( $title ) . '</h1>
                </div>
                <div class="wpmb-block-content">
                    <p>' . do_shortcode( esc_attr( $content ) ) . '</p>
                </div>
            </div>
        </div>';
	}
}
