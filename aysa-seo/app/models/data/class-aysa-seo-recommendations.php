<?php

namespace Aysa\App\Models\Data;

class Aysa_Seo_Recommendations
{
    const RECOMMENDATION_ID = 'id';
    const AYSA_SEO_ID = 'seo_data_id';
    const KEY_ONE_RECOMMENDATION = 'rec_keyword1';
    const KEY_TWO_RECOMMENDATION = 'rec_keyword2';
    const META_TITLE_RECOMMENDATION = 'rec_meta_title';
    const META_KEYWORDS_RECOMMENDATION = 'rec_meta_keywords';
    const META_DESCRIPTION_RECOMMENDATION = 'rec_meta_description';
    const PAGE_TITLE_RECOMMENDATION = 'rec_page_title';
    const DESC_TEXT_RECOMMENDATION = 'rec_desc_text';
    const URL_RECOMMENDATION = 'rec_url';
    const API_RESPONSE = 'api_reponse';

    public function get_id()
    {
        return $this->get_data(self::RECOMMENDATION_ID);
    }

    public function set_id($id)
    {
        $this->set_data(self::RECOMMENDATION_ID, $id);
    }

    public function get_seo_data_id()
    {
        return $this->get_data(self::AYSA_SEO_ID);
    }

    public function set_seo_data_id($seo_data_id)
    {
        $this->set_data(self::AYSA_SEO_ID, $seo_data_id);
    }

    public function get_keyword_one_recommendation()
    {
        return $this->get_data(self::KEY_ONE_RECOMMENDATION);
    }


    public function set_keyword_one_recommendation($keyword_one_recommendation)
    {
        $this->set_data(self::KEY_ONE_RECOMMENDATION, $keyword_one_recommendation);
    }

    public function get_keyword_two_recommendation()
    {
        return $this->get_data(self::KEY_TWO_RECOMMENDATION);
    }

    public function set_keyword_two_recommendation($keyword_two_recommendation)
    {
        $this->set_data(self::KEY_TWO_RECOMMENDATION, $keyword_two_recommendation);
    }

    public function get_meta_title_recommendation()
    {
        return $this->get_data(self::META_TITLE_RECOMMENDATION);
    }

    public function set_meta_title_recommendation($meta_title_recommendation)
    {
        $this->set_data(self::META_TITLE_RECOMMENDATION, $meta_title_recommendation);
    }

    public function get_meta_keywords_recommendation()
    {
        return $this->get_data(self::META_KEYWORDS_RECOMMENDATION);
    }

    public function set_meta_keywords_recommendation($meta_keywords_recommendation)
    {
        $this->set_data(self::META_KEYWORDS_RECOMMENDATION, $meta_keywords_recommendation);
    }

    public function get_meta_description_recommendation()
    {
        return $this->get_data(self::META_DESCRIPTION_RECOMMENDATION);
    }

    public function set_meta_description_recommendation($meta_description_recommendation)
    {
        $this->set_data(self::META_DESCRIPTION_RECOMMENDATION, $meta_description_recommendation);
    }

    public function get_page_title_recommendation()
    {
        return $this->get_data(self::PAGE_TITLE_RECOMMENDATION);
    }

    public function set_page_title_recommendation($page_title_recommendation)
    {
        $this->set_data(self::PAGE_TITLE_RECOMMENDATION, $page_title_recommendation);
    }

    public function get_desc_text_recommendation()
    {
        return $this->get_data(self::DESC_TEXT_RECOMMENDATION);
    }

    public function set_desc_text_recommendation($desc_text_recommendation)
    {
        $this->set_data(self::DESC_TEXT_RECOMMENDATION, $desc_text_recommendation);
    }

    public function get_url_recommendation()
    {
        return $this->get_data(self::URL_RECOMMENDATION);
    }

    public function set_url_recommendation($url_recommendation)
    {
        $this->set_data(self::URL_RECOMMENDATION, $url_recommendation);
    }

    public function get_api_response()
    {
        return json_decode($this->get_data(self::API_RESPONSE), true);
    }

    public function set_api_response($api_response)
    {
        $this->set_data(self::API_RESPONSE, json_encode($api_response));
    }


    public function get_data($key = null)
    {
        return $this->{$key};
    }

    public function set_data($key, $value)
    {
        $this->{$key} = $value;
    }

}