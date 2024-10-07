<?php
namespace Aysa\App\Controllers\Admin;

use Aysa as Aysa;

if ( ! class_exists( __NAMESPACE__ . '\\' . 'Admin_Settings' ) ) {

	/**
	 * Controller class that implements Plugin Admin Settings configurations
	 *
	 * @since      1.0.0
	 * @package    Aysa
	 * @subpackage Aysa/controllers/admin
	 */
	class Admin_Settings extends Base_Controller {

		const SETTINGS_PAGE_SLUG = Aysa::PLUGIN_ID;

		const REQUIRED_CAPABILITY = 'manage_options';

        private static $hook_suffix = 'settings_page_' . Aysa::PLUGIN_ID;

		/**
		 * Register callbacks for actions and filters
		 *
		 * @since    1.0.0
		 */
		public function register_hook_callbacks() {
			// Create Menu.
			add_action( 'admin_menu', array( $this, 'plugin_menu' ) );

			// Enqueue Styles & Scripts.
			add_action( 'admin_print_scripts-' . static::$hook_suffix, array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_print_styles-' . static::$hook_suffix, array( $this, 'enqueue_styles' ) );

			// Register Fields.
			add_action( 'load-' . static::$hook_suffix, array( $this, 'register_fields' ) );

			// Register Settings.
			add_action( 'admin_init', array( $this->get_model(), 'register_settings' ) );

			// Settings Link on Plugin's Page.
			add_filter(
				'plugin_action_links_' . Aysa::PLUGIN_ID . '/' . Aysa::PLUGIN_ID . '.php',
				array( $this, 'add_plugin_action_links' )
			);
		}

		/**
		 * Create menu for Plugin inside Settings menu
		 *
		 * @since    1.0.0
		 */
		public function plugin_menu() {
			static::$hook_suffix = add_options_page(
				__( Aysa::PLUGIN_NAME, Aysa::PLUGIN_ID ),        // Page Title.
				__( Aysa::PLUGIN_NAME, Aysa::PLUGIN_ID ),        // Menu Title.
				static::REQUIRED_CAPABILITY,           // Capability.
				static::SETTINGS_PAGE_SLUG,             // Menu URL.
				array( $this, 'markup_settings_page' ) // Callback.
			);

            add_submenu_page(
                Admin_Dashboard::DASHBOARD_PAGE_SLUG,
                __( 'Settings', Aysa::PLUGIN_ID ),
                __( 'Settings', Aysa::PLUGIN_ID ),
                static::REQUIRED_CAPABILITY,
                static::SETTINGS_PAGE_SLUG,
                array( $this, 'markup_settings_page' )
            );
		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_scripts() {

			/**
			 * This function is provided for demonstration purposes only.
			 */

			wp_enqueue_script(
				Aysa::PLUGIN_ID . '_admin-js',
				Aysa::get_plugin_url() . 'assets/js/admin/aysa-seo.js',
				array( 'jquery' ),
				Aysa::PLUGIN_VERSION,
				true
			);
		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_styles() {

			/**
			 * This function is provided for demonstration purposes only.
			 */

			wp_enqueue_style(
				Aysa::PLUGIN_ID . '_admin-css',
				Aysa::get_plugin_url() . 'assets/css/admin/aysa-seo.css',
				array(),
				Aysa::PLUGIN_VERSION,
				'all'
			);
		}

		/**
		 * Creates the markup for the Settings page
		 *
		 * @since    1.0.0
		 */
		public function markup_settings_page() {
			if ( current_user_can( static::REQUIRED_CAPABILITY ) ) {
				$this->view->admin_settings_page(
					array(
						'page_title'    => Aysa::PLUGIN_NAME,
						'settings_name' => $this->get_model()->get_plugin_settings_option_key(),
					)
				);
			} else {
				wp_die( __( 'Access denied.' ) ); // WPCS: XSS OK.
			}
		}

		/**
		 * Registers settings sections and fields
		 *
		 * @since    1.0.0
		 */
		public function register_fields() {
			add_settings_section(
				'google_analytics_section',
				__( 'Google Analytics', Aysa::PLUGIN_ID ),
				array( $this, 'markup_section_headers' ),
				static::SETTINGS_PAGE_SLUG
			);

			add_settings_field(
				'google_account_id_field',
				__( 'Google Analytics Account:', Aysa::PLUGIN_ID ),
				array( $this, 'markup_fields' ),
				static::SETTINGS_PAGE_SLUG,
				'google_analytics_section',
				array(
					'id'        => 'google_account_id_field',
					'label_for' => 'google_account_id_field',
				)
			);

            add_settings_section(
                'aysa_section',
                __( 'AYSA.ai Account', Aysa::PLUGIN_ID ),
                array( $this, 'markup_section_headers' ),
                static::SETTINGS_PAGE_SLUG
            );

            add_settings_field(
                'aysa_account_id_field',
                __( 'Account Id:', Aysa::PLUGIN_ID ),
                array( $this, 'markup_fields' ),
                static::SETTINGS_PAGE_SLUG,
                'aysa_section',
                array(
                    'id'        => 'aysa_account_id_field',
                    'label_for' => 'aysa_account_id_field',
                )
            );

            add_settings_field(
                'aysa_secret_field',
                __( 'Secret:', Aysa::PLUGIN_ID ),
                array( $this, 'markup_fields' ),
                static::SETTINGS_PAGE_SLUG,
                'aysa_section',
                array(
                    'id'        => 'aysa_secret_field',
                    'label_for' => 'aysa_secret_field',
                )
            );

            add_settings_field(
                'aysa_project_id_field',
                __( 'Project Id:', Aysa::PLUGIN_ID ),
                array( $this, 'markup_fields' ),
                static::SETTINGS_PAGE_SLUG,
                'aysa_section',
                array(
                    'id'        => 'aysa_project_id_field',
                    'label_for' => 'aysa_project_id_field',
                )
            );
		}

		/**
		 * Adds the section introduction text to the Settings page
		 *
		 * @param array $section Array containing information Section Id, Section
		 *                       Title & Section Callback.
		 *
		 * @since    1.0.0
		 */
		public function markup_section_headers( $section ) {
			$this->view->section_headers(
				array(
					'section'      => $section,
					'text_example' => __( 'This is a text example for section header', Aysa::PLUGIN_ID ),
				)
			);
		}

		/**
		 * Delivers the markup for settings fields
		 *
		 * @param array $field_args Field arguments passed in `add_settings_field`
		 *                          function.
		 *
		 * @since    1.0.0
		 */
		public function markup_fields( $field_args ) {
			$field_id = $field_args['id'];
			$settings_value = $this->get_model()->get_setting( $field_id );
			$this->view->markup_fields(
				array(
					'field_id'       => esc_attr( $field_id ),
					'settings_name'  => $this->get_model()->get_plugin_settings_option_key(),
					'settings_value' => ! empty( $settings_value ) ? esc_attr( $settings_value ) : '',
				)
			);
		}

		/**
		 * Adds links to the plugin's action link section on the Plugins page
		 *
		 * @param array $links The links currently mapped to the plugin.
		 * @return array
		 *
		 * @since    1.0.0
		 */
		public function add_plugin_action_links( $links ) {
			$settings_link = '<a href="options-general.php?page=' . static::SETTINGS_PAGE_SLUG . '">' . __( 'Settings', Aysa::PLUGIN_ID ) . '</a>';
			array_unshift( $links, $settings_link );

			return $links;
		}

	}


}
