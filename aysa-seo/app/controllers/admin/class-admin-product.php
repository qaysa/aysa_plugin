<?php

namespace Aysa\App\Controllers\Admin;

use Aysa\App\Helpers\Sync_Data_Service;
use Aysa\Core\Model;

if (!class_exists(__NAMESPACE__ . '\\' . 'Admin_Product')) {
    class Admin_Product extends Base_Controller
    {
        public function __construct(
            Model             $model,
                              $view = false,
            Sync_Data_Service $sync_service = null
        )
        {
            $this->sync_service = $sync_service ?? new Sync_Data_Service();
            parent::__construct($model, $view);
        }

        public function register_hook_callbacks()
        {
            add_action('transition_post_status', [$this, 'sync_data_product_action'], 10, 3);
        }

        public function sync_data_product_action($new_status, $old_status, $post)
        {
            if ('product' !== $post->post_type) {
                return;
            }

            $product = wc_get_product($post->ID);
            if ('publish' == $new_status) {
                $this->sync_service->sync_products([$product]);
            } elseif ('trash' == $new_status) {
                $this->sync_service->delete_products([$product]);
            }
        }
    }
}