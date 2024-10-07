<?php

namespace Aysa\App\Controllers\Admin;

use Aysa;
use Aysa\App\Models\Admin\Data\Table\Rank_Tracker_Table;

if (!class_exists(__NAMESPACE__ . '\\' . 'Rank_Tracker')) {
    class Rank_Tracker extends Base_Controller
    {
        const RANK_TRACKER_PAGE_SLUG = 'aysa-rank-tracker';

        const REQUIRED_CAPABILITY = 'manage_options';

        private static $hook_suffix = 'aysa-ai_page_aysa-rank-tracker';


        public function register_hook_callbacks()
        {
            // Create Rank Tracker Menu.
            add_action('admin_menu', [$this, 'plugin_menu']);
            add_action('load-' . static::$hook_suffix, [$this, 'load_screen_options']);
            add_filter( 'set-screen-option', [ $this, 'set_screen_option' ], 10, 3 );

            // Enqueue Styles & Scripts.
            add_action('admin_print_scripts-' . static::$hook_suffix, [$this, 'enqueue_scripts']);
            add_action('admin_print_styles-' . static::$hook_suffix, [$this, 'enqueue_styles']);
        }

        public function set_screen_option($status, $option, $value) {
            if ( 'items_per_page' == $option ) return $value;
        }

        public function load_screen_options() {
            $option = 'per_page';
            $args   = array(
                'label'   => 'Items',
                'default' => 20,
                'option'  => 'items_per_page'
            );
            add_screen_option( $option, $args );
        }

        public function plugin_menu()
        {
            add_submenu_page(
                Admin_Dashboard::DASHBOARD_PAGE_SLUG,
                __('Rank Tracker', Aysa::PLUGIN_ID),
                __('Rank Tracker', Aysa::PLUGIN_ID),
                static::REQUIRED_CAPABILITY,
                static::RANK_TRACKER_PAGE_SLUG,
                [$this, 'markup_rank_tracker_page']
            );
        }

        public function markup_rank_tracker_page()
        {
            if (current_user_can(static::REQUIRED_CAPABILITY)) {
                $this->view->admin_rank_tracker(  [
                    'page_title' => 'Rank Tracker',
                    'rank_tracker_list_table' => new Rank_Tracker_Table(),
                ]);
            } else {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }
        }

        public function enqueue_scripts()
        {
        }

        public function enqueue_styles()
        {
            wp_enqueue_style(
                Aysa::PLUGIN_ID . '_dashboard_admin-css',
                Aysa::get_plugin_url() . 'assets/css/admin/dashboard.css',
                [],
                Aysa::PLUGIN_VERSION,
                'all'
            );
        }
    }
}