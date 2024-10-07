<?php

namespace Aysa\App\Models\Data\Repository;

use Aysa\App\Models\Data\Aysa_Keyword;

class Keyword_Repository
{
    private $wpdb;

    private $keywords_table;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->keywords_table = $this->wpdb->prefix . 'aysa_keywords';
    }

    /**
     * @param Aysa_Keyword $aysa_Keyword
     *
     * @return int|false
     */
    public function insert(Aysa_Keyword $aysa_Keyword)
    {
        $this->wpdb->insert($this->keywords_table, json_decode(json_encode($aysa_Keyword), true));

        if ($this->wpdb->last_error) {
            return false;
        }

        return $this->wpdb->insert_id;
    }

    /**
     * @param Aysa_Keyword $aysa_Keyword
     *
     * @return int|false
     */
    public function update(Aysa_Keyword $aysa_Keyword)
    {
        $where_condition = [
            'id' => $aysa_Keyword->get_id(),
        ];

        $this->wpdb->update($this->keywords_table, json_decode(json_encode($aysa_Keyword), true), $where_condition);

        if ($this->wpdb->last_error) {
            return false;
        }

        return $aysa_Keyword->get_id();
    }

    public function delete($id)
    {
        $this->wpdb->delete($this->keywords_table, ['id' => $id]);

        if ($this->wpdb->last_error) {
            return false;
        }

        return true;
    }

    public function get_by_id($id)
    {
        $sql = "SELECT * FROM $this->keywords_table WHERE id = $id";

        $result = $this->wpdb->get_row($sql, ARRAY_A);

        if ($this->wpdb->last_error) {
            return false;
        }

        $aysa_keyword = new Aysa_Keyword();
        foreach ($result as $key => $value) {
            $aysa_keyword->set_data($key, $value);
        }

        return $aysa_keyword;
    }
}