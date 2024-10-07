<?php

namespace Aysa\App\Models\Admin\Data\Table;

use Aysa\App\Models\Data\Repository\Rank_Tracker_Repository;
use Aysa\App\Models\Data\Repository\Seo_Repository;
use WP_List_Table;

class Rank_Tracker_Table extends WP_List_Table
{
    private Rank_Tracker_Repository $rank_tracker_repository;

    public function __construct(
        Rank_Tracker_Repository $repository = null,
        $args = array()
    ) {
        $this->rank_tracker_repository = $repository ?? new Rank_Tracker_Repository();

        parent::__construct($args);
    }

    public function prepare_items()
    {
        $user = get_current_user_id();
        $screen = get_current_screen();
        $screen_option = $screen->get_option('per_page', 'option');
        $per_page = get_user_meta($user, $screen_option, true);
        if ( empty ( $per_page) || $per_page < 1 ) {
            $per_page = $screen->get_option( 'per_page', 'default' );
        }

        $currentPage = $this->get_pagenum();
        $search = $this->get_search() ?? '';

        $seo_data = $this->rank_tracker_repository->get_all(
            $per_page,
            ($currentPage - 1) * $per_page,
            $search
        );

        $columns = $this->get_columns();
        $hidden = [];
        $sortable = [];
        $this->_column_headers = [$columns, $hidden, $sortable];

        $this->items = $seo_data;
        $this->set_pagination_args(
            [
                'total_items' => $this->rank_tracker_repository->get_seo_data_count(),
                'per_page' => $per_page,
            ]
        );
    }

    public function get_columns()
    {
        return [
            'cb' => '<input type="checkbox" />',
            'keyword' => 'Keyword',
            'type' => 'Type',
            'entity_id' => 'Entity Id',
            'search_engine' => 'Search Engine',
            'device' => 'Device',
            'position' => 'Position',
            'volume' => 'Volume',
            'language' => 'Language',
            'frequency' => 'Frequency',
            'url_key' => 'Url Key',
            'serp_link' => 'Serp Link',
            'serp' => 'Serp',
            'visibility' => 'Visibility',
            'estimated_traffic' => 'Estimated Traffic',
            'cpc' => 'Cpc',
        ];
    }

    public function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="aysa_seo[]" value="%s" />', $item['id']);
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'keyword':
            case 'type':
            case 'entity_id':
            case 'device':
            case 'position':
            case 'volume':
            case 'language':
            case 'frequency':
            case 'serp_link':
            case 'serp':
            case 'visibility':
            case 'estimated_traffic':
            case 'cpc':
                return $item[$column_name];
            case 'search_engine':
                return $item['targeted_se'];
            case 'url_key':
                return $this->get_url($item);;
            default:
                return print_r($item, true);
        }
    }

    private function get_url($item)
    {
        if ($item['type'] == 'product') {
            return get_permalink($item['entity_id']);
        }
        if ($item['type'] == 'category') {
            $url = get_term_link((int)$item['entity_id']);
            if ($url instanceof \WP_Error) {
                $url = '';
            }

            return $url;
        }

        return '';
    }
}