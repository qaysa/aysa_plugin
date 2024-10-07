<?php
namespace Aysa\App\Controllers\Admin;

use Aysa;
use Aysa\App\Helpers\Sync_Data_Service;
use Aysa\App\Models\Admin\Data\Table\Seo_Data_Table;
use Aysa\Core\Model;

if(!class_exists(__NAMESPACE__ . '\\' . 'Admin_Category')){
    class Admin_Category extends Base_Controller
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
            add_action('created_term', [$this, 'sync_data_category_action'], 10, 3);
            add_action('edited_term', [$this, 'sync_data_category_action'], 10, 3);
            add_action('delete_product_cat', [$this, 'delete_data_category_action'], 10, 4);
        }

        public function sync_data_category_action($term_id, $tt_id, $taxonomy)
        {
            if ('product_cat' !== $taxonomy) {
                return;
            }

            $category = get_term($term_id);

            $this->sync_service->sync_categories([$category]);
        }

        public function delete_data_category_action($term_id, $tt_id, $deleted_term, $object_ids) {
            $this->sync_service->delete_categories([$deleted_term]);
        }
    }
}