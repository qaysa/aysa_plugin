<?php

namespace Aysa\App\Models\Data;

class Aysa_Rank_Tracker
{
    const TRACK_RANKER_ID = 'id';
    const SEO_DATA_ID = 'seo_data_id';
    const KEYWORD_ID = 'keyword_id';
    const AYSA_KEYWORD_ID = 'aysa_keyword_id';
    const POSITION = 'position';
    const VOLUME = 'volume';
    const FREQUENCY = 'frequency';
    const SERP_LINK = 'serp_link';
    const SERP = 'serp';
    const VISIBILITY = 'visibility';
    const ESTIMATED_TRAFFIC = 'estimated_traffic';
    const CPC = 'cpc';

    public function get_id()
    {
        return $this->get_data(self::TRACK_RANKER_ID);
    }

    public function set_id($id)
    {
        $this->set_data(self::TRACK_RANKER_ID, $id);

        return $this;
    }

    public function get_seo_data_id()
    {
        return $this->get_data(self::SEO_DATA_ID);
    }

    public function set_seo_data_id($seo_data_id)
    {
        $this->set_data(self::SEO_DATA_ID, $seo_data_id);

        return $this;
    }

    public function get_keyword_id()
    {
        return $this->get_data(self::KEYWORD_ID);
    }

    public function set_keyword_id($keyword_id)
    {
        $this->set_data(self::KEYWORD_ID, $keyword_id);

        return $this;
    }

    public function get_aysa_keyword_id()
    {
        return $this->get_data(self::AYSA_KEYWORD_ID);
    }

    public function set_aysa_keyword_id($aysa_keyword_id)
    {
        $this->set_data(self::AYSA_KEYWORD_ID, $aysa_keyword_id);

        return $this;
    }

    public function get_position()
    {
        return $this->get_data(self::POSITION);
    }

    public function set_position($position)
    {
        $this->set_data(self::POSITION, $position);

        return $this;
    }

    public function get_volume()
    {
        return $this->get_data(self::VOLUME);
    }

    public function set_volume($volume)
    {
        $this->set_data(self::VOLUME, $volume);

        return $this;
    }

    public function get_frequency()
    {
        return $this->get_data(self::FREQUENCY);
    }

    public function set_frequency($frequency)
    {
        $this->set_data(self::FREQUENCY, $frequency);

        return $this;
    }

    public function get_serp_link()
    {
        return $this->get_data(self::SERP_LINK);
    }

    public function set_serp_link($serp_link)
    {
        $this->set_data(self::SERP_LINK, $serp_link);

        return $this;
    }

    public function get_serp()
    {
        return $this->get_data(self::SERP);
    }

    public function set_serp($serp)
    {
        $this->set_data(self::SERP, $serp);

        return $this;
    }

    public function get_visibility()
    {
        return $this->get_data(self::VISIBILITY);
    }

    public function set_visibility($visibility)
    {
        $this->set_data(self::VISIBILITY, $visibility);

        return $this;
    }

    public function get_estimated_traffic()
    {
        return $this->get_data(self::ESTIMATED_TRAFFIC);
    }

    public function set_estimated_traffic($estimated_traffic)
    {
        $this->set_data(self::ESTIMATED_TRAFFIC, $estimated_traffic);

        return $this;
    }

    public function get_cpc()
    {
        return $this->get_data(self::CPC);
    }

    public function set_cpc($cpc)
    {
        $this->set_data(self::CPC, $cpc);

        return $this;
    }

    public function get_data($key = null)
    {
        return $this->{$key};
    }

    public function set_data($key, $value)
    {
        $this->{$key} = $value;

        return $this;
    }

}