<?php

namespace Aysa\App\Controllers\Admin\Wizard;

use Aysa;
use Aysa\App\Helpers\Settings;
use Aysa\App\Models\Admin\Wizard as WizardModel;
use Aysa\App\Views\Admin\Wizard as WizardView;

require_once  Aysa::get_plugin_path() . 'app/controllers/admin/wizard/interface-wizard-step.php';

class Integrations implements Wizard_Step
{
    private $view;

    private $wizardModel;

    public function __construct(WizardView $view, WizardModel $wizardModel)
    {
        $this->view = $view;
        $this->wizardModel = $wizardModel;
    }

    public function render($wizard)
    {
        $this->view->admin_wizard_integrations_page(
            [
                'page_title' => 'Integrations',
                'settings' => $this->wizardModel->get_settings_class(Settings::INTEGRATIONS_SETTINGS_NAME)
            ]
        );

    }

    public function save($values, $wizard)
    {
       $this->wizardModel->save($values, Settings::INTEGRATIONS_SETTINGS_NAME);
    }
}