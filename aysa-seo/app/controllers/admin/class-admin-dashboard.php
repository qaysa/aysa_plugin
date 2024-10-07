<?php

namespace Aysa\App\Controllers\Admin;

use Aysa;
use Aysa\App\Helpers\Sync_Data_Service;
use Aysa\App\Models\Admin\Data\Table\Seo_Data_Table;
use Aysa\Core\Model;

if (!class_exists(__NAMESPACE__ . '\\' . 'Admin_Dashboard')) {
    class Admin_Dashboard extends Base_Controller
    {
        const REQUIRED_CAPABILITY = 'manage_options';

        const DASHBOARD_PAGE_SLUG = 'aysa-dashboard';

        private static $hook_suffix = 'toplevel_page_aysa-dashboard';

        private Sync_Data_Service $sync_service;

        public function __construct(
            Model $model,
            $view = false,
            Sync_Data_Service $sync_service = null
        ) {
            $this->sync_service = $sync_service ?? new Sync_Data_Service();

            parent::__construct($model, $view);
        }

        public function register_hook_callbacks()
        {
            add_action('admin_menu', [$this, 'plugin_menu']);

            add_action('wp_ajax_aysa_inline_save', [$this, 'aysa_inline_save']);
            add_action('wp_ajax_nopriv_aysa_inline_save', [$this, 'aysa_inline_save']);

            add_action('wp_ajax_aysa_inline_data', [$this, 'aysa_inline_data']);
            add_action('wp_ajax_nopriv_aysa_inline_data', [$this, 'aysa_inline_data']);

            add_action('admin_post_sync_aysa_seo_data', [$this, 'sync_aysa_seo_data']);

            add_action('admin_print_scripts-' . static::$hook_suffix, [$this, 'enqueue_scripts']);
            add_action('admin_print_styles-' . static::$hook_suffix, [$this, 'enqueue_styles']);

            add_action('load-' . static::$hook_suffix, [$this, 'load_screen_options']);
            add_filter( 'set-screen-option', [ $this, 'set_screen_option' ], 10, 3 );
            add_action( 'admin_enqueue_scripts', [$this, 'load_wp_media_files'] );
        }

        public function plugin_menu()
        {
            add_menu_page(
                __(Aysa::PLUGIN_NAME, Aysa::PLUGIN_ID),
                __(Aysa::PLUGIN_NAME, Aysa::PLUGIN_ID),
                static::REQUIRED_CAPABILITY,
                static::DASHBOARD_PAGE_SLUG,
                array($this, 'markup_dashboard_page')
            );
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

        public function markup_dashboard_page()
        {
            if (current_user_can(static::REQUIRED_CAPABILITY)) {
                $this->view->admin_dashboard_page(
                    array(
                        'page_title' => 'AYSA Dashboard',
                        'seo_list_table' => new Seo_Data_Table(),
                    )
                );
            } else {
                wp_die(__('Access denied.'));
            }
        }

        public function enqueue_scripts()
        {
            if ( ! did_action( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            }
            wp_enqueue_script(
                Aysa::PLUGIN_ID . '_dashboard_admin-js',
                Aysa::get_plugin_url() . 'assets/js/admin/dashboard-table.js',
                ['jquery'],
                Aysa::PLUGIN_VERSION,
                true
            );
            wp_enqueue_script('inline-edit-post');
            wp_enqueue_script(
                Aysa::PLUGIN_ID . '_suggestions-js',
                Aysa::get_plugin_url() . 'assets/js/admin/suggestions.js',
                ['jquery'],
                Aysa::PLUGIN_VERSION,
                true
            );
        }

        public function load_wp_media_files() {
            wp_enqueue_media();
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

        public function aysa_inline_save()
        {
            if (empty($_POST['data'])) {
                $response = array(
                    'status' => 'error',
                    'message' => 'No data received',
                );

                wp_send_json($response);
                exit();
            }

            $data = [];
            parse_str($_POST['data'], $data);

            $result = false;

            if ($data['type'] == "product") {
                $result = $this->model->save_product($data);
            }

            if ($data['type'] == "category") {
                $result = $this->model->save_category($data);
            }

            if (!$result) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Error saving data',
                );

                wp_send_json($response);
                exit();
            }

            $response = array(
                'status' => 'success',
                'message' => 'Data saved successfully',
                'data' => $data
            );

            wp_send_json($response);
            exit();
        }

        public function sync_aysa_seo_data()
        {
            $this->sync_service->sync_data();
            wp_safe_redirect(admin_url('/admin.php?page=aysa-dashboard'));
        }

        public function aysa_inline_data()
        {
            if (empty($_GET['data']) || empty($_GET['data']['entity_id']) || empty($_GET['data']['type'])) {
                $response = array(
                    'status' => 'error',
                    'message' => 'No data received',
                );

                wp_send_json($response);
                exit();
            }

            $requestData = $_GET['data'];
            $entity_id = $requestData['entity_id'];
            $type = $requestData['type'];

            $data = $this->model->get_entity_seo_data($entity_id, $type);

            if (!$data) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Error getting data',
                );

                wp_send_json($response);
                exit();
            }

            $response = array(
                'status' => 'success',
                'message' => 'Data saved successfully',
                'data' => $data
            );

            wp_send_json($response);
            exit();
        }
    }
}
