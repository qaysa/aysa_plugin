<?php

namespace Aysa\App\Models\Data;

use Aysa\App\Models\Data\Repository\Keyword_Repository;

class Aysa_Seo
{
    const AYSA_ID = 'id';
    const ENTITY_ID = 'entity_id';
    const TYPE = 'type';
    const KEYWORD_TO_OPTIMIZE = 'keyword_to_optimize';
    const SECOND_KEYWORD = '2nd_keyword';
    const META_TITLE = 'aysa_meta_title';
    const META_KEYWORDS = 'aysa_meta_keywords';
    const META_DESCRIPTION = 'aysa_meta_description';

    private $keyword_repository;

    public function __construct(Keyword_Repository $keyword_repository = null)
    {
        $this->keyword_repository = $keyword_repository ?? new Keyword_Repository();
    }

    public function get_id()
    {
        return $this->get_data(self::AYSA_ID);
    }

    public function set_id($id)
    {
        $this->set_data(self::AYSA_ID, $id);
    }

    public function get_entity_id()
    {
        return $this->get_data(self::ENTITY_ID);
    }

    public function set_entity_id($entity_id)
    {
        $this->set_data(self::ENTITY_ID, $entity_id);

        return $this;
    }

    public function get_type()
    {
        return $this->get_data(self::TYPE);
    }

    public function set_type($type)
    {
        $this->set_data(self::TYPE, $type);

        return $this;
    }

    public function get_keyword_to_optimize_id()
    {
        return $this->get_data(self::KEYWORD_TO_OPTIMIZE);
    }

    public function set_keyword_to_optimize_id($keyword_to_optimize)
    {
        $this->set_data(self::KEYWORD_TO_OPTIMIZE, $keyword_to_optimize);

        return $this;
    }

    public function get_second_keyword_id()
    {
        return $this->get_data(self::SECOND_KEYWORD);
    }

    public function set_second_keyword_id($second_keyword)
    {
        $this->set_data(self::SECOND_KEYWORD, $second_keyword);

        return $this;
    }

    public function get_meta_title()
    {
        return $this->get_data(self::META_TITLE);
    }

    public function set_meta_title($meta_title)
    {
        $this->set_data(self::META_TITLE, $meta_title);

        return $this;
    }

    public function get_meta_keywords()
    {
        return $this->get_data(self::META_KEYWORDS);
    }

    public function set_meta_keywords($meta_keywords)
    {
        $this->set_data(self::META_KEYWORDS, $meta_keywords);

        return $this;
    }

    public function get_meta_description()
    {
        return $this->get_data(self::META_DESCRIPTION);
    }

    public function set_meta_description($meta_description)
    {
        $this->set_data(self::META_DESCRIPTION, $meta_description);

        return $this;
    }

    public function set_track($track)
    {
        $this->set_data('track', $track);

        return $this;
    }

    public function get_track()
    {
        return $this->get_data('track');
    }

    public function get_data($key = null)
    {
        return $this->{$key};
    }

    public function set_data($key, $value)
    {
        $this->{$key} = $value;
    }

    public function get_keyword_to_optimize()
    {
        $keyword_id = $this->get_keyword_to_optimize_id();

        if(!$keyword_id){
            return false;
        }

        return $this->keyword_repository->get_by_id($keyword_id);
    }

    public function get_second_keyword()
    {
        $keyword_id = $this->get_second_keyword_id();

        if(!$keyword_id){
            return false;
        }

        return $this->keyword_repository->get_by_id($keyword_id);

    }
}