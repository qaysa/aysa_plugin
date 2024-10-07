<?php

namespace Aysa\App\Models\Data;

class Aysa_Keyword
{
    const KEYWORD_ID = 'id';
    const KEYWORD_VALUE = 'value';
    const IS_SECOND_KEYWORD = 'is_second_keyword';
    const AYSA_KEYWORD_ID = 'aysa_keyword_id';
    const TARGETED_SE = 'targeted_se';
    const TARGETED_COUNTRY = 'targeted_country';
    const TARGETED_REGION = 'targeted_region';
    const TARGETED_CITY = 'targeted_city';
    const BRAND = 'brand';
    const LANGUAGE = 'language';
    const DEVICE = 'device';

    public function get_id()
    {
        return $this->get_data(self::KEYWORD_ID);
    }

    public function set_id($id)
    {
        $this->set_data(self::KEYWORD_ID, $id);

        return $this;
    }

    public function get_value()
    {
        return $this->get_data(self::KEYWORD_VALUE);
    }

    public function set_value($value)
    {
        $this->set_data(self::KEYWORD_VALUE, $value);

        return $this;
    }

    public function get_is_second_keyword()
    {
        return $this->get_data(self::IS_SECOND_KEYWORD);
    }

    public function set_is_second_keyword($is_second_keyword)
    {
        $this->set_data(self::IS_SECOND_KEYWORD, $is_second_keyword);

        return $this;
    }

    public function get_targeted_se()
    {
        return $this->get_data(self::TARGETED_SE);
    }

    public function set_targeted_se($targeted_se)
    {
        $this->set_data(self::TARGETED_SE, $targeted_se);

        return $this;
    }

    public function get_targeted_country()
    {
        return $this->get_data(self::TARGETED_COUNTRY);
    }

    public function set_targeted_country($targeted_country)
    {
        $this->set_data(self::TARGETED_COUNTRY, $targeted_country);

        return $this;
    }

    public function get_targeted_region()
    {
        return $this->get_data(self::TARGETED_REGION);
    }

    public function set_targeted_region($targeted_region)
    {
        $this->set_data(self::TARGETED_REGION, $targeted_region);

        return $this;
    }

    public function get_targeted_city()
    {
        return $this->get_data(self::TARGETED_CITY);
    }

    public function set_targeted_city($targeted_city)
    {
        $this->set_data(self::TARGETED_CITY, $targeted_city);

        return $this;
    }

    public function get_brand()
    {
        return $this->get_data(self::BRAND);
    }

    public function set_brand($brand)
    {
        $this->set_data(self::BRAND, $brand);

        return $this;
    }

    public function get_language()
    {
        return $this->get_data(self::LANGUAGE);
    }

    public function set_language($language)
    {
        $this->set_data(self::LANGUAGE, $language);

        return $this;
    }

    public function get_device()
    {
        return $this->get_data(self::DEVICE);
    }

    public function set_device($device)
    {
        $this->set_data(self::DEVICE, $device);

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