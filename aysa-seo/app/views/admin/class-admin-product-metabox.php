<?php

namespace Aysa\App\Views\Admin;

use Aysa\Core\View;

if ( ! class_exists( __NAMESPACE__ . '\\' . 'Admin_Product_Metabox' ) ) {
    class Admin_Product_Metabox extends View
    {
        public function admin_product_metabox( $args = [] ) {
            echo $this->render_template(
                'admin/product/metabox.php',
                $args
            );
        }

    }
}