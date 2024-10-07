<?php

namespace Aysa\App\Views\Admin;

use Aysa\Core\View;

if (!class_exists(__NAMESPACE__ . '\\' . 'Wizard')) {

    class Wizard extends View
    {
        public function admin_wizard_general_page($args = [])
        {
            echo $this->render_template(
                'admin/wizard/general-page.php',
                $args
            );
        }

        public function admin_wizard_objectives_page($args = [])
        {
            echo $this->render_template(
                'admin/wizard/objectives-page.php',
                $args
            );
        }

        public function admin_wizard_competition_page($args = [])
        {
            echo $this->render_template(
                'admin/wizard/competition-page.php',
                $args
            );
        }

        public function admin_wizard_integrations_page($args = [])
        {
            echo $this->render_template(
                'admin/wizard/integrations-page.php',
                $args
            );
        }

        public function admin_wizard_keywords_page($args = [])
        {
            echo $this->render_template(
                'admin/wizard/keywords-page.php',
                $args
            );
        }

        public function admin_wizard_seo_settings_page($args = [])
        {
            echo $this->render_template(
                'admin/wizard/seo-settings-page.php',
                $args
            );
        }

        public function admin_wizard_buyer_persona_page($args = [])
        {
            echo $this->render_template(
                'admin/wizard/buyer-persona-page.php',
                $args
            );
        }

        public function admin_wizard_user_persona_page($args = [])
        {
            echo $this->render_template(
                'admin/wizard/user-persona-page.php',
                $args
            );
        }


        public function admin_wizard_tone_voice_page($args = [])
        {
            echo $this->render_template(
                'admin/wizard/tone-voice-page.php',
                $args
            );
        }

        public function admin_wizard_header($args = [])
        {
            echo $this->render_template(
                'admin/wizard/header.php',
                $args
            );
        }

        public function admin_wizard_footer($args = [])
        {
            echo $this->render_template(
                'admin/wizard/footer.php',
                $args
            );
        }

        public function admin_wizard_error($args = [])
        {
            echo $this->render_template(
                'admin/wizard/error.php',
                $args
            );
        }
    }
}