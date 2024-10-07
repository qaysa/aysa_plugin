<?php
/**
 * Plugin Name:       AYSA PowerSEO
 * Plugin URI:        https://www.aysa.ai
 * Description:       Aysa.ai is an AI-powered software designed to help ecommerce businesses increase their sales and revenue.
 * Requires PHP:      7.4
 * Author:            InnovatorSpark
 * Author URI:        https://innovatorspark.com
 * Version:           1.0.2
 * Text Domain:       aysa-seo
 * Domain Path:       languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Creates/Maintains the object of Requirements Checker Class
 *
 * @return \Aysa\Includes\Requirements_Checker
 * @since 1.0.0
 */
function plugin_requirements_checker() {
	static $requirements_checker = null;

	if ( null === $requirements_checker ) {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-requirements-checker.php';
		$requirements_conf = apply_filters( 'aysa_minimum_requirements', include_once( plugin_dir_path( __FILE__ ) . 'requirements-config.php' ) );
		$requirements_checker = new Aysa\Includes\Requirements_Checker( $requirements_conf );
	}

	return $requirements_checker;
}

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_aysa() {

	// If Plugins Requirements are not met.
	if ( ! plugin_requirements_checker()->requirements_met() ) {
		add_action( 'admin_notices', array( plugin_requirements_checker(), 'show_requirements_errors' ) );

		// Deactivate plugin immediately if requirements are not met.
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		deactivate_plugins( plugin_basename( __FILE__ ) );

		return;
	}

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and frontend-facing site hooks.
	 */
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aysa-seo.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	$router_class_name = apply_filters( 'aysa_router_class_name', '\Aysa\Core\Router' );
	$routes = apply_filters( 'aysa_routes_file', plugin_dir_path( __FILE__ ) . 'routes.php' );
	$GLOBALS['aysa'] = new Aysa( $router_class_name, $routes );

	register_activation_hook( __FILE__, array( new Aysa\App\Activator(), 'activate' ) );
	register_deactivation_hook( __FILE__, array( new Aysa\App\Deactivator(), 'deactivate' ) );
}

run_aysa();
