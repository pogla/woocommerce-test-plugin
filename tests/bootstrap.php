<?php

$wp_tests_dir = '/tmp/wordpress-tests-lib';
$wc_tests_dir = '/tmp/woocommerce/tests/framework/';

require_once $wp_tests_dir . '/includes/functions.php';

function _manually_load_plugin() {
	$plugin_dir = '/tmp/';
	require $plugin_dir . 'woocommerce/woocommerce.php';
	require $plugin_dir . 'woocommerce-travis-test/woocommerce-test-plugin.php';
}

tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require $wp_tests_dir . '/includes/bootstrap.php';

require_once( $wc_tests_dir . 'class-wc-mock-session-handler.php' );
require_once( $wc_tests_dir . 'class-wc-unit-test-case.php' );
require_once( $wc_tests_dir . 'helpers/class-wc-helper-product.php' );
require_once( $wc_tests_dir . 'helpers/class-wc-helper-coupon.php' );
require_once( $wc_tests_dir . 'helpers/class-wc-helper-fee.php' );
require_once( $wc_tests_dir . 'helpers/class-wc-helper-shipping.php' );
require_once( $wc_tests_dir . 'helpers/class-wc-helper-customer.php' );
require_once( $wc_tests_dir . 'helpers/class-wc-helper-order.php' );