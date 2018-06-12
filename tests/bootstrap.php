<?php
/**
 * Class WC_Test_Plugin_Tests_Bootstrap
 *
 * PHPUnit bootstrap file
 *
 * @package Woocommerce_Test_Plugin
 */

class WC_Test_Plugin_Tests_Bootstrap {

	/** @var WC_Test_Plugin_Tests_Bootstrap instance */
	protected static $instance = null;
	/** @var string directory where wordpress-tests-lib is installed */
	public $wp_tests_dir;
	/** @var string testing directory */
	public $tests_dir;
	/** @var string plugin directory */
	public $plugin_dir;

	/**
	 * Setup the unit testing environment.
	 *
	 * @since 2.2
	 */
	public function __construct() {
		// phpcs:disable WordPress.PHP.DiscouragedPHPFunctions, WordPress.PHP.DevelopmentFunctions
		ini_set( 'display_errors', 'on' );
		error_reporting( E_ALL );
		// phpcs:enable WordPress.PHP.DiscouragedPHPFunctions, WordPress.PHP.DevelopmentFunctions
		// Ensure server variable is set for WP email functions.
		// phpcs:disable WordPress.VIP.SuperGlobalInputUsage.AccessDetected
		if ( ! isset( $_SERVER['SERVER_NAME'] ) ) {
			$_SERVER['SERVER_NAME'] = 'localhost';
		}
		// phpcs:enable WordPress.VIP.SuperGlobalInputUsage.AccessDetected
		$this->tests_dir    = dirname( __FILE__ );
		$this->plugin_dir   = dirname( $this->tests_dir );
		$this->wp_tests_dir = getenv( 'WP_TESTS_DIR' ) ? getenv( 'WP_TESTS_DIR' ) : '/tmp/wordpress-tests-lib';

		var_dump('tests_dir');
		var_dump($this->tests_dir);
		var_dump('plugin_dir');
		var_dump($this->plugin_dir);
		var_dump('wp_tests_dir');
		var_dump($this->wp_tests_dir);

		// load test function so tests_add_filter() is available
		require_once $this->wp_tests_dir . '/includes/functions.php';
		// load WC
		tests_add_filter( 'muplugins_loaded', array( $this, 'load_wc' ) );
		// install WC
		tests_add_filter( 'setup_theme', array( $this, 'install_wc' ) );
		// load the WP testing environment
		require_once $this->wp_tests_dir . '/includes/bootstrap.php';
		// load WC testing framework
		$this->includes();
	}

	/**
	 * Load WooCommerce.
	 *
	 * @since 2.2
	 */
	public function load_wc() {
		define( 'WC_TAX_ROUNDING_MODE', 'auto' );
		define( 'WC_USE_TRANSACTIONS', false );
		require_once $this->plugin_dir . '/woocommerce.php';
	}

	/**
	 * Install WooCommerce after the test environment and WC have been loaded.
	 *
	 * @since 2.2
	 */
	public function install_wc() {
		// Clean existing install first.
		define( 'WP_UNINSTALL_PLUGIN', true );
		define( 'WC_REMOVE_ALL_DATA', true );
		include $this->plugin_dir . '/uninstall.php';
		WC_Install::install();
		// Reload capabilities after install, see https://core.trac.wordpress.org/ticket/28374
		if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
			$GLOBALS['wp_roles']->reinit();
		} else {
			$GLOBALS['wp_roles'] = null; // WPCS: override ok.
			wp_roles();
		}
		echo esc_html( 'Installing WooCommerce...' . PHP_EOL );
	}

	/**
	 * Load WC-specific test cases and factories.
	 *
	 * @since 2.2
	 */
	public function includes() {
		// framework
		require_once $this->tests_dir . '/framework/class-wc-unit-test-factory.php';
		require_once $this->tests_dir . '/framework/class-wc-mock-session-handler.php';
		require_once $this->tests_dir . '/framework/class-wc-mock-wc-data.php';
		require_once $this->tests_dir . '/framework/class-wc-mock-wc-object-query.php';
		require_once $this->tests_dir . '/framework/class-wc-mock-payment-gateway.php';
		require_once $this->tests_dir . '/framework/class-wc-payment-token-stub.php';
		require_once $this->tests_dir . '/framework/vendor/class-wp-test-spy-rest-server.php';
		// test cases
		require_once $this->tests_dir . '/framework/class-wc-unit-test-case.php';
		require_once $this->tests_dir . '/framework/class-wc-api-unit-test-case.php';
		require_once $this->tests_dir . '/framework/class-wc-rest-unit-test-case.php';
		// Helpers
		require_once $this->tests_dir . '/framework/helpers/class-wc-helper-product.php';
		require_once $this->tests_dir . '/framework/helpers/class-wc-helper-coupon.php';
		require_once $this->tests_dir . '/framework/helpers/class-wc-helper-fee.php';
		require_once $this->tests_dir . '/framework/helpers/class-wc-helper-shipping.php';
		require_once $this->tests_dir . '/framework/helpers/class-wc-helper-customer.php';
		require_once $this->tests_dir . '/framework/helpers/class-wc-helper-order.php';
		require_once $this->tests_dir . '/framework/helpers/class-wc-helper-shipping-zones.php';
		require_once $this->tests_dir . '/framework/helpers/class-wc-helper-payment-token.php';
		require_once $this->tests_dir . '/framework/helpers/class-wc-helper-settings.php';
	}

	/**
	 * Get the single class instance.
	 *
	 * @since 2.2
	 * @return WC_Test_Plugin_Tests_Bootstrap
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}

new WC_Test_Plugin_Tests_Bootstrap();
