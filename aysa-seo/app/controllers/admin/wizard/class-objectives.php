<?php

namespace Aysa\App\Controllers\Admin\Wizard;

use Aysa;
use Aysa\App\Helpers\Settings;
use Aysa\App\Models\Admin\Wizard as WizardModel;
use Aysa\App\Views\Admin\Wizard as WizardView;

require_once Aysa::get_plugin_path() . 'app/controllers/admin/wizard/interface-wizard-step.php';


class Objectives implements Wizard_Step
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
        $this->view->admin_wizard_objectives_page(
            [
                'page_title' => 'Objectives',
                'settings' => $this->wizardModel->get_settings_class(Settings::OBJECTIVES_SETTINGS_NAME),
            ]
        );
    }

    public function save($values, $wizard)
    {
        $this->wizardModel->save($values, Settings::OBJECTIVES_SETTINGS_NAME);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script(
            Aysa::PLUGIN_ID . '_admin-obhectives-js',
            Aysa::get_plugin_url() . 'assets/js/admin/wizard/objectives.js',
            ['jquery'],
            Aysa::PLUGIN_VERSION,
            true
        );
    }
}