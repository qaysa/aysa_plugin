<?php

namespace Aysa\App\Controllers\Admin;

use Aysa;
use Aysa\App\Exceptions\Invalid_Data_Exception;
use Aysa\Core\Model;

if (!class_exists(__NAMESPACE__ . '\\' . 'Wizard')) {

    class Wizard extends Base_Controller
    {
        const WIZARD_PAGE_SLUG = 'aysa-wizard';

        const REQUIRED_CAPABILITY = 'manage_options';

        private static $hook_suffix = 'aysa-ai_page_aysa-wizard';

        private array $steps = [];

        private string $error = '';

        public function __construct(Model $model, $view = false)
        {
            $this->steps();

            parent::__construct($model, $view);
        }

        public function register_hook_callbacks()
        {
            // Create Wizard Menu.
            add_action('admin_menu', [$this, 'plugin_menu']);
            add_action('admin_post_aysa_wizard_save', [$this, 'save_wizard']);

            // Enqueue Styles & Scripts.
            add_action('admin_print_scripts-' . static::$hook_suffix, [$this, 'enqueue_scripts']);
            add_action('admin_print_styles-' . static::$hook_suffix, [$this, 'enqueue_styles']);
        }

        public function plugin_menu()
        {
            add_submenu_page(
                Admin_Dashboard::DASHBOARD_PAGE_SLUG,
                __('Setup Wizard', Aysa::PLUGIN_ID),
                __('Setup Wizard', Aysa::PLUGIN_ID),
                static::REQUIRED_CAPABILITY,
                static::WIZARD_PAGE_SLUG,
                [$this, 'markup_wizard_page']
            );
        }

        public function markup_wizard_page()
        {
            if (current_user_can(static::REQUIRED_CAPABILITY)) {
                $step = $this->get_current_step();
                $step_class = new $this->steps[$step]['class']($this->view, $this->model);

                if(isset($_GET['error'])){
                    $this->view->admin_wizard_error(['error' => $_GET['error']]);
                }
                $this->view->admin_wizard_header(['steps' => $this->steps, 'current' => $step]);
                $step_class->render($this);
                $this->view->admin_wizard_footer(['next' => $this->get_next_step($step)]);
            } else {
                wp_die(__('Access denied.'));
            }
        }

        public function save_wizard()
        {
            $step = $this->get_current_step();
            $step_class = new $this->steps[$step]['class']($this->view, $this->model);

            try {
                $step_class->save($_POST, $this);

                if ($step == array_key_last($this->steps)) {
                    wp_redirect(admin_url('/admin.php?page=aysa-dashboard'));
                    return;
                }

                $nextStep = $this->get_next_step($step);
                wp_redirect(admin_url('/admin.php?page=aysa-wizard&step=' . $nextStep));
            } catch (Invalid_Data_Exception $e) {
                $this->error = __($e->getMessage(), Aysa::PLUGIN_ID);
                wp_redirect(admin_url('/admin.php?page=aysa-wizard&step=' . $step . '&error=' . $this->error));
            } catch (\Exception $e) {
                $this->error = __('There has been an error while saving the data', Aysa::PLUGIN_ID);
                wp_redirect(admin_url('/admin.php?page=aysa-wizard&step=' . $step));
            }
        }

        private function steps()
        {
            $this->steps = [
                'integrations' => [
                    'name' => esc_html__('Integrations', Aysa::PLUGIN_ID),
                    'class' => 'Aysa\\App\\Controllers\\Admin\\Wizard\\Integrations',
                ],
                'general' => [
                    'name' => esc_html__('General Information', Aysa::PLUGIN_ID),
                    'class' => 'Aysa\\App\\Controllers\\Admin\\Wizard\\General_Information',
                ],
                'objectives' => [
                    'name' => esc_html__('Objectives', Aysa::PLUGIN_ID),
                    'class' => 'Aysa\\App\\Controllers\\Admin\\Wizard\\Objectives',
                ],
                'competition' => [
                    'name' => esc_html__('Competition', Aysa::PLUGIN_ID),
                    'class' => 'Aysa\\App\\Controllers\\Admin\\Wizard\\Competition',
                ],
                'keywords' => [
                    'name' => esc_html__('Keywords', Aysa::PLUGIN_ID),
                    'class' => 'Aysa\\App\\Controllers\\Admin\\Wizard\\Keywords',
                ],
                'seo-settings' => [
                    'name' => esc_html__('Seo Settings', Aysa::PLUGIN_ID),
                    'class' => 'Aysa\\App\\Controllers\\Admin\\Wizard\\Seo_Settings',
                ],
                'tone-of-voice' => [
                    'name' => esc_html__('Tone of Voice', Aysa::PLUGIN_ID),
                    'class' => 'Aysa\\App\\Controllers\\Admin\\Wizard\\Tone_Voice',
                ]
            ];
        }

        private function get_current_step()
        {
            if (isset($_GET['step'])) {
                return $_GET['step'];
            }

            if (isset($_POST['step'])) {
                return $_POST['step'];
            }

            return 'integrations';
        }

        private function get_next_step(string $step)
        {
            $keys = array_keys($this->steps);
            $index = array_search($step, $keys);

            if ($index === false) {
                throw new \Exception('Invalid step');
            }

            if (isset($keys[$index + 1])) {
                return $keys[$index + 1];
            }

            return false;
        }

        public function enqueue_scripts()
        {
            wp_enqueue_script(
                Aysa::PLUGIN_ID . '_admin-js',
                Aysa::get_plugin_url() . 'assets/js/admin/wizard/wizard.js',
                ['jquery'],
                Aysa::PLUGIN_VERSION,
                true
            );
            wp_enqueue_script(
                Aysa::PLUGIN_ID . '_select2-js',
                Aysa::get_plugin_url() . 'assets/vendor/select2/select2.js',
                ['jquery'],
                Aysa::PLUGIN_VERSION,
                true);
        }

        public function enqueue_styles()
        {
            wp_enqueue_style(
                Aysa::PLUGIN_ID . '_admin-css',
                Aysa::get_plugin_url() . 'assets/css/admin/wizard.css',
                [],
                Aysa::PLUGIN_VERSION,
                'all'
            );
            wp_enqueue_style(
                Aysa::PLUGIN_ID . '_select2-css',
                Aysa::get_plugin_url() . 'assets/vendor/select2/select2.css',
                [],
                Aysa::PLUGIN_VERSION,
                'all'
            );
        }
    }
}