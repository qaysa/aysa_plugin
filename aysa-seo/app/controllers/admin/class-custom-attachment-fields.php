<?php

namespace Aysa\App\Controllers\Admin;

use Aysa\App\Models\Data\Repository\Seo_Recommendations_Repository;
use Aysa\App\Models\Data\Repository\Seo_Repository;
use Aysa\Core\Model;

class Custom_Attachment_Fields extends Base_Controller
{

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
        add_filter('attachment_fields_to_edit', array($this, 'add_aysa_media_fields'), 10, 2);
    }

    public function add_aysa_media_fields($form_fields, $post)
    {
        if (!$this->can_add_fields()) {
            return $form_fields;
        }

        $entity = $this->get_entity();

        if (!$entity) {
            return $form_fields;
        }
        $this->seo_data = $this->seo_data_repository->get_entity_seo_data($entity['id'], $entity['type']);

        if (!$this->seo_data) {
            return $form_fields;
        }

        $seo_recommendations = $this->seo_recommendations_repository->get_by_seo_data_id($this->seo_data->get_id());
        if (!$seo_recommendations) {
            return $form_fields;
        }

        $seo_api_response = $seo_recommendations->get_api_response();
        $form_fields['rec_img_name'] = [
            'label' => 'Suggested Image Name',
            'input' => 'text',
            'value' => $seo_api_response['rec_img_name'] ?? '',
        ];
        $form_fields['rec_img_alt_text'] = [
            'label' => 'Suggested Image Alt Text',
            'input' => 'text',
            'value' => $seo_api_response['rec_img_alt_text'] ?? '',
        ];

        return $form_fields;
    }

    private function can_add_fields()
    {
        $current_post_type = get_post_type();
        if ($current_post_type === 'product') {
            return true;
        }

        if ($_POST['query'] && $_POST['query']['entityId']) {
            return true;
        }

        return false;
    }

    private function get_entity()
    {
        if ($_POST['query'] && $_POST['query']['entityId']) {
            return [
                'id' => $_POST['query']['entityId'],
                'type' => $_POST['query']['entityType']
            ];
        }

        return null;
    }
}
