<?php

namespace Aysa\App\Helpers;

use Aysa\App\Models\Data\Aysa_Seo;
use Aysa\App\Models\Data\Repository\Seo_Repository;

class Sync_Data_Service
{
    private Seo_Repository $seo_repository;

    public function __construct(Seo_Repository $seo_Repository = null)
    {
        $this->seo_repository = $seo_Repository ?? new Seo_Repository();
        add_action('activate_sync_data', [$this, 'sync_data']);
    }

    public function sync_data()
    {
        $this->sync_products();
        $this->sync_categories();
    }

    public function sync_products($products = null)
    {
        $products = $products ?? wc_get_products([
            'limit' => -1,
            'status' => 'publish',
        ]);

        foreach ($products as $product) {
            $seo_data = $this->seo_repository->get_by_product($product->get_id());
            if (!$seo_data) {
                $aysa = new Aysa_Seo();
                $aysa->set_entity_id($product->get_id());
                $aysa->set_type('product');
                $this->seo_repository->insert($aysa);
            } else {
                $this->seo_repository->update($seo_data);
            }
        }
    }

    public function sync_categories($categories = null)
    {
        $categories = $categories ?? get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ]);

        foreach ($categories as $category) {
            $seo_data = $this->seo_repository->get_by_category($category->term_id);
            if (!$seo_data) {
                $aysa = new Aysa_Seo();
                $aysa->set_entity_id($category->term_id);
                $aysa->set_type('category');
                $this->seo_repository->insert($aysa);
            } else {
                $this->seo_repository->update($seo_data);
            }
        }
    }

    public function delete_products($products) {
        foreach ($products as $product) {
            $seo_data = $this->seo_repository->get_by_product($product->get_id());
            $this->seo_repository->delete($seo_data);
        }
    }

    public function delete_categories($categories) {
        foreach ($categories as $category) {
            $seo_data = $this->seo_repository->get_by_category($category->term_id);
            $this->seo_repository->delete($seo_data);
        }
    }
}