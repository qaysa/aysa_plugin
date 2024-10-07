<?php

namespace Aysa\App\Models\Data\Repository;

use Aysa\App\Models\Data\Aysa_Seo_Recommendations;

class Seo_Recommendations_Repository
{
    private $wpdb;

    private string $recommendations_table;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->recommendations_table = $this->wpdb->prefix . 'aysa_seo_recommendations';
    }

    /**
     * @param $seo_data_id
     *
     * @return Aysa_Seo_Recommendations|false
     */
    public function get_by_seo_data_id($seo_data_id)
    {
        $sql = "SELECT * FROM $this->recommendations_table WHERE seo_data_id = $seo_data_id";

        $result = $this->wpdb->get_row($sql, ARRAY_A);

        if (!$result || $this->wpdb->last_error) {
            return false;
        }

        $seo_recommendations = new Aysa_Seo_Recommendations();
        foreach ($result as $key => $value) {
            $seo_recommendations->set_data($key, $value);
        }

        return $seo_recommendations;
    }

    /**
     * @param $seo_recommendation
     *
     * @return int|bool
     */
    public function insert($seo_recommendation)
    {
        $this->wpdb->insert($this->recommendations_table, json_decode(json_encode($seo_recommendation), true));

        if ($this->wpdb->last_error) {
            return false;
        }

        return $this->wpdb->insert_id;
    }

    /**
     * @param Aysa_Seo_Recommendations $seo_recommendation
     *
     * @return int|bool
     */
    public function update(Aysa_Seo_Recommendations $seo_recommendation)
    {

        $where_condition = [
            'id' => $seo_recommendation->get_id(),
        ];

        $this->wpdb->update(
            $this->recommendations_table,
            json_decode(json_encode($seo_recommendation), true),
            $where_condition
        );

        if ($this->wpdb->last_error) {
            return false;
        }

        return $seo_recommendation->get_id();
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function delete($id): bool
    {
        $this->wpdb->delete($this->recommendations_table, ['id' => $id]);

        if ($this->wpdb->last_error) {
            return false;
        }

        return true;
    }
}