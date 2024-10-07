<?php

namespace Aysa\App\Controllers\Admin;

use Aysa;
use Aysa\App\Helpers\Settings;
use Aysa\App\Models\Data\Repository\Seo_Recommendations_Repository;
use Aysa\App\Models\Data\Repository\Seo_Repository;
use Aysa\Core\Model;

class Product_Metabox extends Base_Controller
{

    const REQUIRED_CAPABILITY = 'manage_options';
    private Seo_Repository $seo_data_repository;

    private Seo_Recommendations_Repository $seo_recommendations_repository;

    private $seo_data = null;

    public function __construct(Model $model, $view = false)
    {
        $this->seo_data_repository = new Seo_Repository();
        $this->seo_recommendations_repository = new Seo_Recommendations_Repository();

        parent::__construct($model, $view);
    }

    public function register_hook_callbacks()
    {
        add_action('add_meta_boxes', [$this, 'create_custom_meta_box']);
        add_action('save_post', [$this, 'save_custom_content_meta_box'], 10, 1);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('product_cat_edit_form', [$this, 'add_cat_metabox'], 1);
    }

    public function enqueue_scripts($hook)
    {
        global $post;

        // Check if we're on the product edit or add new product page
        if ($hook == 'post-new.php' || $hook == 'post.php' || $hook == 'term.php') {
            if ('product' === $post->post_type || $_GET['taxonomy'] == 'product_cat') {
                wp_enqueue_style(
                    Aysa::PLUGIN_ID . '_product_metabox_admin-css',
                    Aysa::get_plugin_url() . 'assets/css/admin/metabox.css',
                    [],
                    Aysa::PLUGIN_VERSION,
                    'all'
                );
                wp_enqueue_script(
                    Aysa::PLUGIN_ID . '_product_metabox_admin-js',
                    Aysa::get_plugin_url() . 'assets/js/admin/metabox.js',
                    ['jquery'],
                    Aysa::PLUGIN_VERSION,
                    true
                );
            }
        }
    }

    public function add_cat_metabox()
    {
        echo '<div id="custom_product_meta_box" class="postbox category_box"><div class="postbox-header"><h2>AYSA SEO</h2></div><div class="inside">';
        $this->markup_dashboard_page();
        echo '</div></div>';
    }

    public function create_custom_meta_box()
    {
        add_meta_box(
            'custom_product_meta_box',
            __('AYSA SEO', 'cmb'),
            [$this, 'markup_dashboard_page'],
            'product',
            'normal',
            'default'
        );
    }

    public function markup_dashboard_page()
    {
        if (current_user_can(static::REQUIRED_CAPABILITY)) {
            $this->view->admin_product_metabox([
                'settings' => new Settings(Settings::SEO_SETTINGS_NAME)
            ]);
        } else {
            wp_die(__('Access denied.'));
        }
    }

    public function save_custom_content_meta_box($post_id)
    {
        // ... your saving logic here ...
    }
}
