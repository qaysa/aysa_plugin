<?php

namespace Aysa\App\Controllers\Admin\Wizard;

use Aysa;
use Aysa\App\Helpers\Settings;
use Aysa\App\Models\Admin\Wizard as WizardModel;
use Aysa\App\Views\Admin\Wizard as WizardView;

require_once Aysa::get_plugin_path() . 'app/controllers/admin/wizard/interface-wizard-step.php';


class Seo_Settings implements Wizard_Step
{
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
        $this->view->admin_wizard_seo_settings_page(
            [
                'page_title' => 'SEO Settings',
                'settings' => $this->wizardModel->get_settings_class(Settings::SEO_SETTINGS_NAME)
            ]
        );
    }

    public function save($values, $wizard)
    {
        $this->wizardModel->save($values, Settings::SEO_SETTINGS_NAME);
    }

    public function enqueue_scripts()
    {
        if(defined('GOOGLE_PLACES_API_KEY')) {
            wp_enqueue_script(
                'google-places',
                'https://maps.googleapis.com/maps/api/js?key='.
                GOOGLE_PLACES_API_KEY.
                '&libraries=places'
            );

            wp_enqueue_script(
                'google-places-autocomplete',
                Aysa::get_plugin_url() . 'assets/js/admin/wizard/google-places-autocomplete.js',
                ['jquery'],
                Aysa::PLUGIN_VERSION,
                true
            );
        }

        wp_enqueue_script(
            Aysa::PLUGIN_ID . '_admin-seo-settings-js',
            Aysa::get_plugin_url() . 'assets/js/admin/wizard/seo-settings.js',
            ['jquery'],
            Aysa::PLUGIN_VERSION,
            true
        );
    }
}