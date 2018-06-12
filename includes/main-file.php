<?php

class WooCommerce_TestPlugin {

	private static $instance;
	public $version = '1';

	public function __construct() {

		if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}

		// Check if WooCommerce is active
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			if ( ! is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) {
				return;
			}
		}

		// Initialize plugin parts
		$this->init();

	}

	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Init.
	 *
	 * Initialize plugin parts.
	 *
	 * @since 1.0.0
	 */
	public function init() {
	}

	/**
	 * Flush rewrite rules.
	 *
	 * Flush the rewrite rules on plugin activation so cart_url post type works.
	 *
	 * @since 1.0.0
	 */
	public function rewrite_flush() {
	}

	/**
	 * Admin style.
	 *
	 * Enqueue admin stylesheet.
	 *
	 * @since 1.0.0
	 *
	 * @global object $post Global post object.
	 */
	public function admin_enqueue() {
	}
}
