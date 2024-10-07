<?php

namespace Aysa\App\Models\Admin\Data\Table;

use Aysa\App\Models\Data\Repository\Keyword_Repository;
use Aysa\App\Models\Data\Repository\Seo_Repository;
use WP_List_Table;

class Seo_Data_Table extends WP_List_Table
{
    private Seo_Repository $seo_repository;

    private Keyword_Repository $keyword_repository;

    public function __construct(
        Seo_Repository     $repository = null,
        Keyword_Repository $keyword_repository = null,
                           $args = array()
    )
    {
        $this->seo_repository = $repository ?? new Seo_Repository();
        $this->keyword_repository = $keyword_repository ?? new Keyword_Repository();

        parent::__construct($args);
    }

    public function prepare_items()
    {
        $user = get_current_user_id();
        $screen = get_current_screen();
        $screen_option = $screen->get_option('per_page', 'option');
        $per_page = get_user_meta($user, $screen_option, true);
        if (empty ($per_page) || $per_page < 1) {
            $per_page = $screen->get_option('per_page', 'default');
        }

        $currentPage = $this->get_pagenum();
        $search = $this->get_search() ?? '';
        $filters = $this->get_filter() ?? [];

        $seo_data = $this->seo_repository->get_all(
            $per_page,
            ($currentPage - 1) * $per_page,
            $search,
            $filters
        );

        $columns = $this->get_columns();
        $hidden = [];
        $sortable = [];
        $this->_column_headers = [$columns, $hidden, $sortable];

        $this->items = $seo_data;
        $this->set_pagination_args(
            [
                'total_items' => $this->seo_repository->get_seo_data_count(),
                'per_page' => $per_page,
            ]
        );
    }

    public function get_columns()
    {
        return [
            'cb' => '<input type="checkbox" />',
            'name' => 'Name',
            'slug' => 'Permalink',
            'type' => 'Type',
            'keyword' => 'Keyword',
            'second_keyword' => 'Second Keyword',
            'aysa_meta_title' => 'Meta Title',
            'aysa_meta_keywords' => 'Meta Keywords',
            'aysa_meta_description' => 'Meta Description',
        ];
    }

    public function column_default($item, $column_name)
    {
        $keyword = "";
        if ($column_name == 'keyword' && $item['keyword_to_optimize']) {
            $keyword = $this->keyword_repository->get_by_id($item['keyword_to_optimize'])->get_value();
        }

        $second_keyword = "";
        if ($column_name == 'second_keyword' && $item['2nd_keyword']) {
            $second_keyword = $this->keyword_repository->get_by_id($item['2nd_keyword'])->get_value();
        }

        switch ($column_name) {
            case 'type':
            case 'name':
            case 'aysa_meta_title':
            case 'aysa_meta_keywords':
            case 'aysa_meta_description':
            case 'slug':
                return $item[$column_name];
            case 'keyword':
                return $keyword;
            case 'second_keyword':
                return $second_keyword;
            default:
                return print_r($item, true);
        }
    }


    public function column_name($item)
    {
        $actions = [
            'quickEdit' => sprintf(
                '<a href="#" class="editinline" data-id="%s" data-type="%s">Edit</a>',
                $item['entity_id'],
                $item['type']
            )
        ];

        $name = '<div class=row-title>' . $item['name'] . '</div>';

        return $name . $this->row_actions($actions);
    }

    public function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="aysa_seo[]" value="%s" />', $item['id']);
    }

    public function single_row($item)
    {
        $id = 'product-' . $item['entity_id'];
        if ($item['type'] == 'category') {
            $id = 'category-' . $item['entity_id'];
        }

        ?>
        <tr id="<?php echo $id; ?>" class="iedit">
            <?php $this->single_row_columns($item); ?>
        </tr>
        <?php
    }

    private function get_search()
    {
        return isset($_REQUEST['s']) ? filter_var($_REQUEST['s'], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_BACKTICK) : false;
    }

    private function get_filter()
    {
        $filters = [];
        if (isset($_REQUEST['type']) && $_REQUEST['type'] != '0') {
            $filters['type'] =  filter_var($_REQUEST['type'], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_BACKTICK);
        }

        return $filters;
    }

    public function search_box($text, $input_id)
    {
        if (empty($_REQUEST['s']) && !$this->has_items()) {
            return;
        }

        $input_id = $input_id . '-search-input';

        if (!empty($_REQUEST['orderby'])) {
            echo '<input type="hidden" name="orderby" value="' . esc_attr($_REQUEST['orderby']) . '" />';
        }
        if (!empty($_REQUEST['order'])) {
            echo '<input type="hidden" name="order" value="' . esc_attr($_REQUEST['order']) . '" />';
        }
        if (!empty($_REQUEST['post_mime_type'])) {
            echo '<input type="hidden" name="post_mime_type" value="' . esc_attr($_REQUEST['post_mime_type']) . '" />';
        }
        if (!empty($_REQUEST['detached'])) {
            echo '<input type="hidden" name="detached" value="' . esc_attr($_REQUEST['detached']) . '" />';
        }
        ?>
        <p class="search-box">
            <label class="screen-reader-text" for="<?php echo esc_attr($input_id); ?>"><?php echo $text; ?>:</label>
            <input type="search" placeholder="Search" id="<?php echo esc_attr($input_id); ?>" name="s"
                   value="<?php _admin_search_query(); ?>"/>
            <?php submit_button($text, '', '', false, array('id' => 'search-submit')); ?>
        </p>
        <?php
    }

    public function filter_options()
    {
        return [
            '0' => [
                'label' => 'Type',
                'selected' => !isset($_REQUEST['type'])
            ],
            'product' => [
                'label' => 'Product',
                'selected' => isset($_REQUEST['type']) && $_REQUEST['type'] == 'product'
            ],
            'category' => [
                'label' => 'Category',
                'selected' => isset($_REQUEST['type']) && $_REQUEST['type'] == 'category'
            ],
        ];
    }
}