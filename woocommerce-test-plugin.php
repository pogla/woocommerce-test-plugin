<?php
/**
 * Plugin Name: 	WooCommerce Test Plugin
 * Version: 		1.0.0
 * WC tested up to: 3.3.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'woocommerce_test_plugin' ) ) {
	function woocommerce_test_plugin() {
		require_once( 'includes/main-file.php' );
		return WooCommerce_TestPlugin::instance();
	}
}

woocommerce_test_plugin();
