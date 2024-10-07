<?php

namespace Aysa\App\Controllers\Admin\Wizard;

interface Wizard_Step
{
    public function render($wizard);

    public function save($values, $wizard);
}