<?php

namespace Aysa\App;

use Aysa\App\Helpers\Sync_Data_Service;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Aysa
 * @subpackage Aysa/App
 */
class Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public function activate()
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $this->create_keywords_table();
        $this->create_seo_data();
        $this->create_rank_tracker_table();
        $this->create_seo_recommendations_table();

        new Sync_Data_Service();
        as_schedule_single_action( time(), 'activate_sync_data' );
    }

    private function create_seo_data()
    {
        global $wpdb;
        $tableName = $wpdb->prefix . 'aysa_seo_data';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $tableName (
            `id` int UNSIGNED AUTO_INCREMENT COMMENT 'ID',
            `entity_id` varchar(1024) DEFAULT NULL COMMENT 'Page Id, Product Id, Category Id',
            `type` varchar(1024) NOT NULL COMMENT 'Type(page,product,category)',
            `keyword_to_optimize` int UNSIGNED DEFAULT NULL COMMENT 'Keyword to optimize Id',
            `2nd_keyword` int UNSIGNED DEFAULT NULL COMMENT '2nd keyword',
            `aysa_meta_title` text(1024) DEFAULT NULL COMMENT 'Meta tile of the page',
            `aysa_meta_keywords` text(1024) DEFAULT NULL COMMENT 'Meta keywords of the page',
            `aysa_meta_description` text(1024) DEFAULT NULL COMMENT 'Meta description of the page',
            `targeted_se` varchar(1024) DEFAULT NULL COMMENT 'Targeted SE',
            `targeted_country` varchar(1024) DEFAULT NULL COMMENT 'Targeted Country',
            `targeted_region` varchar(1024) DEFAULT NULL COMMENT 'Targeted Country Region',
            `targeted_city` varchar(1024) DEFAULT NULL COMMENT 'Targeted City',
            `brand` varchar(1024) DEFAULT NULL COMMENT 'Branch',
            `language` varchar(64) DEFAULT NULL COMMENT 'Language',
            `device` varchar(1024) DEFAULT NULL COMMENT 'Device',
            `objective` varchar(1024) DEFAULT NULL COMMENT 'Objective',
            `track` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Track', 
            `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Update At',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Time',
            PRIMARY KEY  (id),
            FOREIGN KEY (keyword_to_optimize) REFERENCES $wpdb->prefix" . "aysa_keywords(id),
            FOREIGN KEY (2nd_keyword) REFERENCES $wpdb->prefix" . "aysa_keywords(id)
          ) $charset_collate;";

        dbDelta($sql);
    }

    private function create_keywords_table()
    {
        global $wpdb;
        $tableName = $wpdb->prefix . 'aysa_keywords';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $tableName (
            `id` int UNSIGNED AUTO_INCREMENT COMMENT 'ID',
            `value` varchar(1024) NOT NULL COMMENT 'Keyword Value',
            `is_second_keyword` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Is Second Keyword',    
            `aysa_keyword_id` int UNSIGNED NOT NULL COMMENT 'Aysa Keyword Id',       
            `targeted_se` varchar(1024) DEFAULT NULL COMMENT 'Targeted SE',
            `targeted_country` varchar(1024) DEFAULT NULL COMMENT 'Targeted Country',
            `targeted_region` varchar(1024) DEFAULT NULL COMMENT 'Targeted Country Region',
            `targeted_city` varchar(1024) DEFAULT NULL COMMENT 'Targeted City',
            `brand` varchar(1024) DEFAULT NULL COMMENT 'Branch',
            `language` varchar(64) DEFAULT NULL COMMENT 'Language',
            `device` varchar(1024) DEFAULT NULL COMMENT 'Device',
            `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Update At',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Time',
            PRIMARY KEY  (id)
          ) $charset_collate;";

        dbDelta($sql);
    }

    private function create_rank_tracker_table()
    {
        global $wpdb;
        $tableName = $wpdb->prefix . 'aysa_rank_tracker';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $tableName (
            `id` int UNSIGNED AUTO_INCREMENT COMMENT 'ID',
            `seo_data_id` int UNSIGNED NOT NULL COMMENT 'Seo Data Id',
            `keyword_id` int UNSIGNED NOT NULL COMMENT 'Keyword Id',
            `aysa_keyword_id` int UNSIGNED NOT NULL COMMENT 'Aysa Keyword Id',
            `position` varchar(255) DEFAULT NULL COMMENT 'Position',
            `volume` varchar(255) DEFAULT NULL COMMENT 'Volume',
            `frequency` varchar(1024) DEFAULT NULL COMMENT 'Frequency',
            `serp_link` varchar(1024) DEFAULT NULL COMMENT 'Serp Link',
            `serp` varchar(1024) DEFAULT NULL COMMENT 'Serp',
            `visibility` varchar(1024) DEFAULT NULL COMMENT 'Visibility',
            `estimated_traffic` varchar(1024) DEFAULT NULL COMMENT 'Estimated Traffic',
            `cpc` varchar(1024) DEFAULT NULL COMMENT 'CPC',
            `scheduled_at` timestamp DEFAULT NULL COMMENT 'Scheduled at', 
            `executet_at` timestamp DEFAULT NULL COMMENT 'Executet at', 
            `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Update At',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Time',
            PRIMARY KEY  (id),
            FOREIGN KEY (seo_data_id) REFERENCES $wpdb->prefix" . "aysa_seo_data(id),
            FOREIGN KEY (keyword_id) REFERENCES $wpdb->prefix" . "aysa_keywords(id)
          ) $charset_collate;";

        dbDelta($sql);
    }

    private function create_seo_recommendations_table()
    {
        global $wpdb;
        $tableName = $wpdb->prefix . 'aysa_seo_recommendations';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $tableName (
            `id` int UNSIGNED AUTO_INCREMENT COMMENT 'ID',
            `seo_data_id` int UNSIGNED NOT NULL COMMENT 'Seo Data Id',
            `rec_keyword1` varchar(255) DEFAULT NULL COMMENT 'Recomended Keyword',
            `rec_keyword2` varchar(255) DEFAULT NULL COMMENT 'Recommended Second Keyword',
            `rec_meta_title` varchar(255) DEFAULT NULL COMMENT 'Recommended Meta Title',
            `rec_meta_keywords` varchar(255) DEFAULT NULL COMMENT 'Recommended Meta Keywords',
            `rec_meta_description` longtext DEFAULT NULL COMMENT 'Recommended Meta Description',
            `rec_page_title` varchar(1024) DEFAULT NULL COMMENT 'Recommended Page Title',
            `rec_desc_text` longtext DEFAULT NULL COMMENT 'Recommended Description Text',
            `rec_url` varchar(1024) DEFAULT NULL COMMENT 'Recommended Url',
            `api_reponse` longtext DEFAULT NULL COMMENT 'Api Response',
            `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Update At',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Time',
            PRIMARY KEY  (id),
            FOREIGN KEY (seo_data_id) REFERENCES $wpdb->prefix" . "aysa_seo_data(id)          ) $charset_collate;";

        dbDelta($sql);
    }
}
