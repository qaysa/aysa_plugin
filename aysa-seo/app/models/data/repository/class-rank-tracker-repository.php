<?php

namespace Aysa\App\Models\Data\Repository;

use Aysa\App\Models\Data\Aysa_Rank_Tracker;

class Rank_Tracker_Repository
{
    private $wpdb;

    private string $rank_tracker_table;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->rank_tracker_table = $this->wpdb->prefix . 'aysa_rank_tracker';
    }

    public function get_all($limit = 10, $offset = 0, $search = '', $output = null)
    {
        $postsTable = $this->wpdb->prefix . 'posts';
        $seoTable = $this->wpdb->prefix . 'aysa_seo_data';
        $termsTable = $this->wpdb->prefix . 'terms';
        $taxonomyTermsTable = $this->wpdb->prefix . 'term_taxonomy';
        $keywords = $this->wpdb->prefix . 'aysa_keywords';
        $statement = sprintf(
            "SELECT 
            rankTracker.*,
            keywords.*,
            seoData.*,
            keywords.value as keyword,
            COALESCE(posts.post_title, terms.name) AS name
        FROM %s as rankTracker
        JOIN %s seoData on seoData.id = rankTracker.seo_data_id
        JOIN %s keywords on keywords.id = rankTracker.keyword_id
        LEFT JOIN %s posts on posts.ID = seoData.entity_id and posts.post_type = 'product' and seoData.type = 'product'
        LEFT JOIN %s terms on terms.term_id = seoData.entity_id and seoData.type = 'category'
        LEFT JOIN %s tax on tax.term_id = terms.term_id and tax.taxonomy = 'product_cat'",
            $this->rank_tracker_table,
            $seoTable,
            $keywords,
            $postsTable,
            $termsTable,
            $taxonomyTermsTable,
        );
        if ($search) {
            $statement = $statement . sprintf(
                    'WHERE keywords.value LIKE "%%%1$s%%"',
                    $search
                );
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
            $rank_tracker = new Aysa_Rank_Tracker();
            foreach ($data as $key => $value) {
                $rank_tracker->set_data($key, $value);
            }

            $aysa_result[] = $rank_tracker;
        }
        dd($aysa_result);

        return $aysa_result;
    }

    public function get_by_schedule()
    {
        $sql = $this->wpdb->prepare(
            "SELECT * FROM $this->rank_tracker_table WHERE schedule_date <= %s",
            date('Y-m-d H:i:s')
        );
        $result = $this->wpdb->get_results($sql, ARRAY_A);

        if ($this->wpdb->last_error) {
            return false;
        }

        $aysa_result = [];
        foreach ($result as $data) {
            $rank_tracker = new Aysa_Rank_Tracker();
            foreach ($data as $key => $value) {
                $rank_tracker->set_data($key, $value);
            }

            $aysa_result[] = $rank_tracker;
        }

        return $aysa_result;
    }

    /**
     * @return string|null
     */
    public function get_seo_data_count()
    {
        $sql = "SELECT count(*) FROM $this->rank_tracker_table";

        return $this->wpdb->get_var($sql);
    }

    /**
     * @param int $keyword_id
     *
     * @return Aysa_Rank_Tracker|false
     */
    public function get_by_keyword(int $keyword_id)
    {
        if (!$keyword_id) {
            return false;
        }

        $sql = $this->wpdb->prepare(
            "SELECT * FROM $this->rank_tracker_table WHERE keyword_id = %s",
            $keyword_id
        );
        $result = $this->wpdb->get_row($sql, ARRAY_A);

        if ($this->wpdb->last_error || !$result) {
            return false;
        }

        $aysa_rank_tracker = new Aysa_Rank_Tracker();
        foreach ($result as $key => $value) {
            $aysa_rank_tracker->set_data($key, $value);
        }

        return $aysa_rank_tracker;
    }

    /**
     * @param Aysa_Rank_Tracker $rank_Tracker
     *
     * @return int|bool
     */
    public function update(Aysa_Rank_Tracker $rank_Tracker)
    {
        $where_condition = [
            'seo_data_id' => $rank_Tracker->get_seo_data_id(),
            'keyword_id' => $rank_Tracker->get_keyword_id(),
        ];

        $this->wpdb->update(
            $this->rank_tracker_table,
            json_decode(json_encode($rank_Tracker), true),
            $where_condition
        );

        if ($this->wpdb->last_error) {
            return false;
        }

        return $rank_Tracker->get_id();
    }

    /**
     * @param Aysa_Rank_Tracker $rank_Tracker
     *
     * @return int|false
     */
    public function insert(Aysa_Rank_Tracker $rank_Tracker)
    {
        $this->wpdb->insert(
            $this->rank_tracker_table,
            json_decode(json_encode($rank_Tracker), true)
        );

        if ($this->wpdb->last_error) {
            return false;
        }

        return $this->wpdb->insert_id;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id)
    {
        $this->wpdb->delete($this->rank_tracker_table, ['id' => $id]);

        if ($this->wpdb->last_error) {
            return false;
        }

        return true;
    }
}