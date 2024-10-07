<?php

namespace Aysa\App\Models\Admin;

use Aysa\App\Helpers\Settings;
use Aysa\App\Models\Data\Aysa_Seo;
use Aysa\App\Models\Data\Aysa_Seo_Recommendations;
use Aysa\App\Models\Data\Repository\Keyword_Repository;
use Aysa\App\Models\Data\Repository\Seo_Recommendations_Repository;
use Aysa\App\Models\Data\Repository\Seo_Repository;
use Aysa\App\Vendors\Aysa\Aysa_Api;

class Get_Suggestions extends Base_Model
{
    private Seo_Repository $seo_repository;

    private Aysa_Api $aysa_api;

    private Settings $seoSettings;

    private Settings $integrationSettings;

    private Seo_Recommendations_Repository $seo_recommendations_repository;

    private Keyword_Repository $keyword_repository;

    public function __construct(
        Seo_Repository $seo_repository = null,
        Aysa_Api $aysa_api = null,
        Settings $seoSettings = null,
        Settings $integrationSettings = null,
        Seo_Recommendations_Repository $seo_recommendations_repository = null,
        Keyword_Repository $keyword_repository = null
    ) {
        $this->seo_repository = $seo_repository ?? new Seo_Repository();
        $this->aysa_api = $aysa_api ?? new Aysa_Api();
        $this->seoSettings = $seoSettings ?? new Settings(Settings::SEO_SETTINGS_NAME);
        $this->integrationSettings = $integrationSettings ?? new Settings(Settings::INTEGRATIONS_SETTINGS_NAME);
        $this->seo_recommendations_repository = $seo_recommendations_repository ?? new Seo_Recommendations_Repository();
        $this->keyword_repository = $keyword_repository ?? new Keyword_Repository();
    }

    /**
     * @param string $entity_id
     * @param int $type
     *
     * @return array
     *
     * @throws \Exception
     */
    public function get_aysa_saved_suggestions(string $entity_id,string $type): array
    {
        $seoData = $this->seo_repository->get_entity_seo_data($entity_id, $type);

        if(!$seoData){
            throw new \Exception('Error getting seo data.');
        }

        $recommendations = $this->seo_recommendations_repository->get_by_seo_data_id($seoData->get_id());

        if (!$recommendations) {
            throw new \Exception('No data available.');
        }

        return $this->build_recommendations($recommendations);
    }

    /**
     * @param string $entity_id
     * @param string $type
     *
     * @return array
     *
     * @throws \Exception
     */
    public function get_aysa_suggestions(string $entity_id,string $type): array
    {
        $seoData = $this->seo_repository->get_entity_seo_data($entity_id, $type);
        if(!$seoData){
            throw new \Exception('Error getting seo data.');
        }

        $requestData = $this->build_request_data($seoData);
        $response = $this->aysa_api->get_suggestions($requestData);
        if(!$response){
            throw new \Exception('Error getting suggestions.');
        }

        $response = $response->get_content();
        if($response['error'] == 'true') {
            $message = null;
            if($response['message'] ){
                $message = json_encode($response['message']);
            }
            throw new \Exception(
                $message ? "Error getting suggestions: {$message}":
                    "Error getting suggestions"
            );
        }

        $recommendation = $this->create_recommendation($response, $seoData->get_id());
        $this->update_external_keywords_ids($response, $seoData);

        return $this->build_recommendations($recommendation);
    }

    /**
     * @param Aysa_Seo $seoData
     *
     * @return array
     */
    private function build_request_data(Aysa_Seo $seoData): array
    {
        $url = '';
        if($seoData->get_type() == 'product') {
            $product = wc_get_product($seoData->get_entity_id());
            $url = $product->get_permalink();
        }

        if($seoData->get_type() == 'category') {
            $category = get_term($seoData->get_entity_id());
            $url = get_term_link($category);
        }

        return [
            'entity_type' => $seoData->get_type(),
            'entity_url' => $url,
            'keyword1' => $seoData->get_keyword_to_optimize() ? $seoData->get_keyword_to_optimize()->get_value() : '' ,
            'keyword2' => $seoData->get_second_keyword() ? $seoData->get_second_keyword()->get_value() : '' ,
            'tg_search_engine' => $this->seoSettings->get_setting('targeted_se'),
            'tg_country' => $this->seoSettings->get_setting('targeted_country'),
            'tg_city' => $this->seoSettings->get_setting('targeted_city'),
            'tg_subdivision' => $this->seoSettings->get_setting('targeted_region'),
            'language' => $this->seoSettings->get_setting('language-optimize'),
            'brand_name' =>  $this->seoSettings->get_setting('targeted_brand') ,
            'device' => $this->seoSettings->get_setting('device-optimize'),
            'source_meta_title' => $seoData->get_meta_title(),
            'source_meta_keywords' => $seoData->get_meta_keywords(),
            'source_meta_description' => $seoData->get_meta_description(),
            'source_h1' =>  '',
            'frequency' => $this->seoSettings->get_setting('update_frequency'),
            'project_id' =>  $this->integrationSettings->get_setting('aysa-project-id'),
            'account_id' =>  $this->integrationSettings->get_setting('aysa-account-id'),
            'secret' =>  $this->integrationSettings->get_setting('aysa-secret'),
        ];
    }

    /**
     * @param array $response
     * @param int $seo_id
     *
     * @return Aysa_Seo_Recommendations
     *
     * @throws \Exception
     */
    private function create_recommendation(array $response,int $seo_id): Aysa_Seo_Recommendations
    {
        $recommendation = new Aysa_Seo_Recommendations();
        $recommendation->set_seo_data_id($seo_id);
        $recommendation->set_keyword_one_recommendation($response['rec_keyword1']['keyword']  ?? '');
        $recommendation->set_keyword_two_recommendation($response['rec_keyword2']['keyword']  ?? '');
        $recommendation->set_meta_title_recommendation($response['rec_meta_description'] ?? '');
        $recommendation->set_meta_description_recommendation($response['rec_meta_description'] ?? '');
        $recommendation->set_meta_keywords_recommendation( $response['rec_meta_keywords'] ?? '');
        $recommendation->set_page_title_recommendation($response['rec_page_title'] ?? '');
        $recommendation->set_desc_text_recommendation($response['rec_desc_text'] ?? '');
        $recommendation->set_url_recommendation( $response['rec_url'] ?? '');
        $recommendation->set_api_response($response);

        if($this->seo_recommendations_repository->get_by_seo_data_id($seo_id)){
            $recommendationId = $this->seo_recommendations_repository->get_by_seo_data_id($seo_id)->get_id();
            $recommendation->set_id($recommendationId);
            if(!$this->seo_recommendations_repository->update($recommendation)) {
             throw new \Exception('Error updating seo recommendation');
            }

            return $recommendation;
        }

        if(!$this->seo_recommendations_repository->insert($recommendation)){
            throw new \Exception('Error inserting seo recommendation');
        }

        return $recommendation;
    }

    /**
     * @param Aysa_Seo_Recommendations $recommendation
     *
     * @return array
     */
    private function build_recommendations(Aysa_Seo_Recommendations $recommendation):array
    {
        $recommendations  = [];
        $recommendations['suggested-keyword'] = $recommendation->get_keyword_one_recommendation() ?? '';
        $recommendations['suggested-second-keyword'] = $recommendation->get_keyword_two_recommendation() ?? '';
        $recommendations['aysa_suggested_meta_title'] = $recommendation->get_meta_title_recommendation() ?? '';
        $recommendations['aysa_suggested_meta_description'] = $recommendation->get_meta_description_recommendation() ?? '';
        $recommendations['aysa_suggested_suggested_meta_keywords'] = $recommendation->get_meta_keywords_recommendation() ?? '';
        $recommendations['suggested-name'] = $recommendation->get_page_title_recommendation() ?? '';
        $recommendations['suggested-description'] = $recommendation->get_desc_text_recommendation() ?? '';
        $recommendations['suggested-slug'] = $recommendation->get_url_recommendation() ?? '';
        $recommendations['suggestion_errors'] = $recommendation->get_api_response()['SUGGESTIONS'] ?? '';

        return $recommendations;
    }

    private function update_external_keywords_ids($response,Aysa_Seo $seoData)
    {
        if($seoData->get_keyword_to_optimize()){
            $keyword = $seoData->get_keyword_to_optimize();
            $keyword->set_data('aysa_keyword_id', $response['request_ids']['kw1']['id']);
            $keyword->set_aysa_keyword_id($response['request_ids']['kw1']['id']);
            $this->keyword_repository->update($keyword);
        }
        if($seoData->get_second_keyword()){
            $keyword = $seoData->get_second_keyword();
            $keyword->set_aysa_keyword_id($response['request_ids']['kw2']['id']);
            $this->keyword_repository->update($keyword);
        }
    }
}