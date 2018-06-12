<?php
/**
 * Class WC_Test_Plugin_Tests_Bootstrap
 *
 * PHPUnit bootstrap file
 *
 * @package Woocommerce_Test_Plugin
 */

class WC_Test_Plugin_Tests_Bootstrap {

	public $wpTestsDir  = null;
	public $testsDir    = null;
	public $pluginDir   = null;
	public $modulesDir   = null;
	public $wcTestsDir   = null;

	/**
	 * Constructor to the bootstrap file
	 */
	public function __construct() {

		if ( ! isset( $_SERVER['SERVER_NAME'] ) ) {
			$_SERVER['SERVER_NAME'] = 'localhost';
		}

		if ( getenv( 'WP_MULTISITE' ) ) {
			define( 'WP_TESTS_MULTISITE', 1 );
		}

		if ( ! defined( 'WC_UNIT_TESTING' ) ) {
			define( 'WC_UNIT_TESTING', true );
		}

		$this->testsDir = dirname(__FILE__);
		$this->pluginDir = dirname($this->testsDir);

		$this->wpTestsDir = getenv( 'WP_TESTS_DIR' ) ? getenv( 'WP_TESTS_DIR' ) : '/tmp/wordpress-tests-lib';
		$this->wcTestsDir = getenv( 'WC_TESTS_DIR' ) ? getenv( 'WC_TESTS_DIR' ) : '/tmp/woocommerce';

//		var_dump('PHP testsDir:');
//		var_dump($this->testsDir);
//		var_dump('PHP pluginDir:');
//		var_dump($this->pluginDir);
//		var_dump('PHP wpTestsDir:');
//		var_dump($this->wpTestsDir);

		// load test function so tests_add_filter() is available
		include_once $this->wpTestsDir . '/includes/functions.php';

		// Load WooCommerce
		tests_add_filter( 'muplugins_loaded', array( $this, 'loadWooCommerce' ) );

		// Load the plugin
		tests_add_filter( 'muplugins_loaded', array( $this, 'loadPlugin' ) );

		// Start up the WP testing environment.
		include_once $this->wpTestsDir . '/includes/bootstrap.php';

		// Include utility classes
		$this->includes();

		// Install the plugin
		$this->install();
	}

	/**
	 * Loads the plugin for the current PHPUnit runtime
	 *
	 * @return void
	 */
	public function loadPlugin() {
		include_once $this->pluginDir . '/woocommerce-cart-url.php';
	}

	/**
	 * Loads the WooCommerce plugin for the current PHPUnit runtime
	 *
	 * @return void
	 */
	public function loadWooCommerce() {
		require_once $this->wcTestsDir . '/woocommerce.php';
	}

	/**
	 * Loads the required files.
	 */
	private function includes() {
		// Load WC Helper functions/Frameworks and Factories.
		require_once( $this->wcTestsDir . '/tests/framework/helpers/class-wc-helper-product.php' );
		require_once( $this->wcTestsDir . '/tests/framework/helpers/class-wc-helper-order.php' );
		require_once( $this->wcTestsDir . '/tests/framework/helpers/class-wc-helper-shipping.php' );
	}
}

new WC_Test_Plugin_Tests_Bootstrap();