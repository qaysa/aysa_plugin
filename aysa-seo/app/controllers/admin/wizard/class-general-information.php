<?php

namespace Aysa\App\Controllers\Admin\Wizard;

use Aysa;
use Aysa\App\Exceptions\Invalid_Data_Exception;
use Aysa\App\Helpers\Settings;
use Aysa\App\Views\Admin\Wizard as WizardView;
use Aysa\App\Models\Admin\Wizard as WizardModel;
use WC_Shipping_Zones;

require_once Aysa::get_plugin_path() . 'app/controllers/admin/wizard/interface-wizard-step.php';

class General_Information implements Wizard_Step
{
    const STEP_NAME = 'general';

    private $view;

    private $wizardModel;

    public function __construct(WizardView $view, WizardModel $wizardModel)
    {
        $this->view = $view;
        $this->wizardModel = $wizardModel;

        $this->enqueue_scripts();
    }

    public function render($wizard)
    {
        $this->view->admin_wizard_general_page(
            [
                'page_title' => 'General Information',
                'settings' => $this->wizardModel->get_settings_class(Settings::GENERAL_SETTINGS_NAME),
                'shipping_methods' => implode(', ', $this->get_shipping_methods()),
                'payment_methods' => implode(', ', $this->get_payment_methods()),
            ]
        );
    }

    public function save($values, $wizard)
    {
        if (empty($values)) {
            throw new Invalid_Data_Exception('Empty values');
        }
        if (($values['action']) !== null) {
            unset($values['action']);
        }
        if (($values['step']) !== null) {
            unset($values['step']);
        }

        $this->wizardModel->save($values, Settings::GENERAL_SETTINGS_NAME);
    }

    private function get_shipping_methods()
    {
        if (!class_exists('WC_Shipping_Zones')) {
            return [];
        }

        $zones = WC_Shipping_Zones::get_zones();

        $shipping_methods = [];
        foreach ($zones as $zone) {
            foreach ($zone['shipping_methods'] as $shipping_method) {
                $shipping_methods[] = $shipping_method->title;
            }
        }

        return $shipping_methods;
    }

    private function get_payment_methods()
    {
        if (!function_exists('WC')) {
            return [];
        }

        $gateways = WC()->payment_gateways->get_available_payment_gateways();
        $payment_methods = [];
        foreach ($gateways as $gateway) {
            if ($gateway->enabled == 'yes') {
                $payment_methods[] = $gateway->title;
            }
        }

        return $payment_methods;
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script(
            Aysa::PLUGIN_ID . '_admin-general-js',
            Aysa::get_plugin_url() . 'assets/js/admin/wizard/general.js',
            ['jquery'],
            Aysa::PLUGIN_VERSION,
            true
        );
    }
}