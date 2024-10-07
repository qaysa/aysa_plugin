<?php

namespace Aysa\App\Views\Admin;

use Aysa\Core\View;

if ( ! class_exists( __NAMESPACE__ . '\\' . 'Admin_Dashboard' ) ) {
    class Admin_Dashboard extends View
    {
        public function admin_dashboard_page( $args = [] ) {
            echo $this->render_template(
                'admin/dashboard/dashboard-page.php',
                $args
            );
        }

        public function admin_inline_edit( $args = [] ) {
            return $this->render_template(
                'admin/dashboard/components/inline-edit-template.php',
                $args
            );
        }

    }
}