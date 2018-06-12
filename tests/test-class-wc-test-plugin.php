<?php
/**
 * Class WC_Plugin_Test
 *
 * @package Woocommerce_Cart_Url
 */

class WC_Plugin_Test extends WP_UnitTestCase {

	public function test_initial_function_exists() {
		$this->assertTrue( class_exists( 'woocommerce_test_plugin' ) );
		$this->assertTrue( class_exists( 'WooCommerce_TestPlugin' ) );
	}
}
