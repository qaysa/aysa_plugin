<?php

namespace Aysa\App\Models\Admin;

use Aysa\App\Helpers\Settings;
use Aysa\App\Models\Data\Repository\Keyword_Repository;
use Aysa\App\Models\Data\Repository\Seo_Recommendations_Repository;
use Aysa\App\Models\Data\Repository\Seo_Repository;
use Aysa\App\Vendors\Aysa\Aysa_Api;

class Get_Ranks extends Base_Model
{

    private Seo_Repository $seo_repository;

    private Aysa_Api $aysa_api;

    private Settings $settings;

    private Seo_Recommendations_Repository $seo_recommendations_repository;

    private Keyword_Repository $keyword_repository;

    public function __construct(
        Seo_Repository $seo_repository = null,
        Aysa_Api $aysa_api = null,
        Settings $settings = null,
        Seo_Recommendations_Repository $seo_recommendations_repository = null,
        Keyword_Repository $keyword_repository = null
    ) {
        $this->seo_repository = $seo_repository ?? new Seo_Repository();
        $this->aysa_api = $aysa_api ?? new Aysa_Api();
        $this->settings = $settings ?? new Settings();
        $this->seo_recommendations_repository = $seo_recommendations_repository ?? new Seo_Recommendations_Repository();
        $this->keyword_repository = $keyword_repository ?? new Keyword_Repository();
    }

    public function get_ranks($data)
    {
        $params = [
            'project_id' =>  $this->settings->get_setting('aysa-project-id', Settings::INTEGRATIONS_SETTINGS_NAME),
            'account_id' =>  $this->settings->get_setting('aysa-account-id', Settings::INTEGRATIONS_SETTINGS_NAME),
            'secret' =>  $this->settings->get_setting('aysa-secret', Settings::INTEGRATIONS_SETTINGS_NAME),
            'req_ids_list' => implode(',' , $data['req_ids_list']),
        ];
        $response = $this->aysa_api->get_ranks($params);

        if (!$response) {
            throw new \Exception('No data available.');
        }

        return $response;
    }
}