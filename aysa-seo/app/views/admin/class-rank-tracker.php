<?php

namespace Aysa\App\Views\Admin;

use Aysa\Core\View;

if (!class_exists(__NAMESPACE__ . '\\' . 'Rank_Tracker')) {
    class Rank_Tracker extends View
    {
        public function admin_rank_tracker($args = [])
        {
            echo $this->render_template(
                'admin/rank-tracker/tracker-page.php',
                $args
            );
        }
    }
}