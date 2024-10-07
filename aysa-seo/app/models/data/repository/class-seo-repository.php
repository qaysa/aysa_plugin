<?php

namespace Aysa\App\Models\Data\Repository;

use Aysa\App\Models\Data\Aysa_Seo;

class Seo_Repository
{
    private $wpdb;

    private string $seoTable;

    public function __construct()
    {
        global $wpdb;

        $this->wpdb = $wpdb;
        $this->seoTable = $this->wpdb->prefix . 'aysa_seo_data';
    }

    public function get_all($limit = 10, $offset = 0, $search = '', $filters = [], $output = null)
    {
        $postsTable = $this->wpdb->prefix . 'posts';
        $seoTable = $this->wpdb->prefix . 'aysa_seo_data';
        $termsTable = $this->wpdb->prefix . 'terms';
        $taxonomyTermsTable = $this->wpdb->prefix . 'term_taxonomy';
        $statement = sprintf(
            "SELECT
                aysa.*, 
                COALESCE(posts.post_title, terms.name) AS name,
                COALESCE(posts.post_name, terms.slug) AS slug,
                posts.post_excerpt as short_description,
                COALESCE( posts.post_content, tax.description) as description
            From %s aysa
            LEFT JOIN %s posts on posts.ID = aysa.entity_id and posts.post_type = 'product' and aysa.type = 'product'
            LEFT JOIN %s terms on terms.term_id = aysa.entity_id and aysa.type = 'category'
            LEFT JOIN %s tax on tax.term_id = terms.term_id and tax.taxonomy = 'product_cat' ",
            $seoTable,
            $postsTable,
            $termsTable,
            $taxonomyTermsTable
        );

        $conditions = $this->get_conditions($search, $filters);

        if (!empty($conditions)) {
            $statement = $statement . 'WHERE ' . implode(' AND ', $conditions);
        }

        $statement = $statement . sprintf("LIMIT %s OFFSET %s;", $limit, $offset);

        $result = $this->wpdb->get_results($statement, ARRAY_A);

        if ($this->wpdb->last_error) {
            return false;
        }

        if ($output != 'OBJECT') {
            return $result;
        }

        $aysa_result = [];
        foreach ($result as $data) {
            $aysa_data = new Aysa_Seo();
            foreach ($data as $key => $value) {
                $aysa_data->set_data($key, $value);
            }

            $aysa_result[] = $aysa_data;
        }

        return $aysa_result;
    }

    private function get_conditions($search, $filters)
    {
        $conditions = [];

        if ($search) {
            $searchCondition = sprintf('(posts.post_title LIKE "%%%1$s%%" OR terms.name LIKE "%%%1$s%%")', $search);
            $conditions[] = $searchCondition;
        }

        if (!empty($filters)) {
            $filterConditions = [];
            foreach ($filters as $key => $value) {
                if ($value) {
                    $filterCondition = sprintf('(aysa.%1$s = "%2$s")', $key, $value);
                    $filterConditions[] = $filterCondition;
                }
            }
            if (!empty($filterConditions)) {
                $conditions[] = implode(' AND ', $filterConditions);
            }
        }

        return $conditions;
    }

    /**
     * @return string|null
     */
    public function get_seo_data_count()
    {
        $sql = "SELECT count(*) FROM $this->seoTable";

        return $this->wpdb->get_var($sql);
    }

    /**
     * @param Aysa_Seo $aysa_seo
     * @return int
     *
     * @throws \Exception
     */
    public function insert(Aysa_Seo $aysa_seo)
    {
        $seoTable = $this->wpdb->prefix . 'aysa_seo_data';

        $this->wpdb->insert($seoTable, json_decode(json_encode($aysa_seo), true));

        if ($this->wpdb->last_error) {
            return false;
        }

        return $this->wpdb->insert_id;
    }

    /**
     * @param Aysa_Seo $aysa_seo
     * @return int|false
     */
    public function update(Aysa_Seo $aysa_seo)
    {
        $seoTable = $this->wpdb->prefix . 'aysa_seo_data';
        $where_condition = [
            'entity_id' => $aysa_seo->get_entity_id(),
            'type' => $aysa_seo->get_type(),
        ];

        $this->wpdb->update($seoTable, json_decode(json_encode($aysa_seo), true), $where_condition);

        if ($this->wpdb->last_error) {
            return false;
        }

        return $aysa_seo->get_entity_id();
    }

    /**
     * @param $id
     *
     * @return Aysa_Seo|false
     */
    public function get_by_product($id)
    {
        return $this->get_entity_seo_data($id, 'product');
    }

    /**
     * @param $id
     *
     * @return Aysa_Seo|false
     */
    public function get_by_category($id)
    {
        return $this->get_entity_seo_data($id, 'category');
    }

    /**
     * @param $id
     * @param $type
     *
     * @return Aysa_Seo|false
     */
    public function get_entity_seo_data($id, $type)
    {
        $where_condition = [
            'entity_id' => $id,
            'type' => $type,
        ];

        $query = $this->wpdb->prepare(
            "SELECT * FROM $this->seoTable WHERE entity_id = %s AND type = %s",
            $where_condition['entity_id'],
            $where_condition['type']
        );

        $results = $this->wpdb->get_results($query, ARRAY_A);

        if ($this->wpdb->last_error) {
            return false;
        }

        if (!isset($results[0])) {
            return false;
        }

        $aysa = new Aysa_Seo();
        foreach ($results[0] as $key => $value) {
            $aysa->set_data($key, $value);
        }

        return $aysa;
    }

    /**
     * Deletes an Aysa_Seo record.
     *
     * @param Aysa_Seo $aysa_seo
     * @return bool
     */
    public function delete(Aysa_Seo $aysa_seo)
    {
        $seoTable = $this->wpdb->prefix . 'aysa_seo_data';
        $where_condition = [
            'entity_id' => $aysa_seo->get_entity_id(),
            'type' => $aysa_seo->get_type(),
        ];

        $this->wpdb->delete($seoTable, $where_condition);

        if ($this->wpdb->last_error) {
            return false;
        }

        return true;
    }
}