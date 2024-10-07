<?php

namespace Aysa\App\Helpers;

use Aysa;
use Aysa\App\Exceptions\Invalid_Data_Exception;
use Aysa\Core\Model;

class Settings extends Model
{
    const GENERAL_SETTINGS_NAME = 'aysa-options-general';
    const OBJECTIVES_SETTINGS_NAME = 'aysa-options-objectives';
    const INTEGRATIONS_SETTINGS_NAME = 'aysa-options-integrations';
    const COMPETITION_SETTINGS_NAME = 'aysa-options-competition';
    const KEYWORDS_SETTINGS_NAME = 'aysa-options-keywords';
    const SEO_SETTINGS_NAME = 'aysa-options-seo';
    const BUYER_PERSONA_NAME = 'aysa-buyer-persona';
    const USER_PERSONA_NAME = 'aysa-user-persona';
    const TONE_VOICE_NAME = 'aysa-tone-voice';

    protected $settingsName = '';

    protected $settings;

    public function __construct($settingsName = null)
    {
        $this->settingsName = $settingsName ?? self::GENERAL_SETTINGS_NAME;
    }

    /**
     * @return array
     */
    public function get_settings($settings_name = null)
    {
        if (isset($settings_name)) {
            return get_option($settings_name);
        }

        if (!isset($this->settings)) {
            $this->settings = get_option($this->settingsName);
        }

        return $this->settings;
    }

    /**
     * @param string $setting_name Setting to be retrieved.
     * @return mixed
     */
    public function get_setting($setting_name, $settings_name = null)
    {
        $all_settings = $this->get_settings($settings_name);

        return $all_settings[$setting_name] ?? null;
    }

    /**
     * @return void
     * @since 1.0.0
     */
    public function delete_settings()
    {
        $this->settings = [];

        delete_option($this->settingsName);
    }

    /**
     * Helper method to delete a specific setting
     *
     * @param string $setting_name Setting to be Deleted.
     * @return void
     * @since 1.0.0
     */
    public function delete_setting($setting_name)
    {
        $all_settings = $this->get_settings();

        if (isset($all_settings[$setting_name])) {
            unset($all_settings[$setting_name]);
            $this->settings = $all_settings;

            update_option($this->settingsName, $all_settings);
        }
    }

    /**
     * @param $new_settings
     * @return void
     * @throws \Exception
     */
    public function save_settings($new_settings): void
    {
        $all_settings = $this->get_settings();

        if ($all_settings === null) {
            $result = add_option($this->settingsName, $new_settings);
            if (!$result) {
                throw new Invalid_Data_Exception('Error adding settings');
            }
            return;
        }

        if($all_settings && is_array($all_settings)){
            $updated_settings = array_merge($all_settings, $new_settings);
        } else{
            $updated_settings = $new_settings;
        }

        $this->settings = $updated_settings;

        update_option($this->settingsName, $updated_settings);
    }

    public function get_website_types()
    {
        return [
            'online_store' => 'Online Store',
        ];
    }

    public function get_industries()
    {
        return [
            'fashion' => 'Fashion',
            'it' => 'It',
            'mix' => 'Mix'
        ];
    }

    public function get_objectives()
    {
        return [
            'more-traffic' => __('Attract more traffic to our website', Aysa::PLUGIN_ID),
            'brand-awareness' => __('Increase brand awareness', Aysa::PLUGIN_ID),
            'leads' => __('Generate Leads', Aysa::PLUGIN_ID),
            'sales-revenue' => __('Generate Sales Revenue', Aysa::PLUGIN_ID),
            'promote-improve' => __('Promote New Products / Improve Product Positioning', Aysa::PLUGIN_ID),
            'bounce-rate' => __('CTR / BOUNCE RATE / CONVERSION', Aysa::PLUGIN_ID),
        ];
    }
    public function get_tone_voice()
    {
        return [
            'formal' => __('Formal', Aysa::PLUGIN_ID),
            'informal' => __('Informal', Aysa::PLUGIN_ID),
            'humorous' => __('Humorous', Aysa::PLUGIN_ID),
            'serious' => __('Serious', Aysa::PLUGIN_ID),
            'optimistic' => __('Optimistic', Aysa::PLUGIN_ID),
            'motivational' => __('Motivational', Aysa::PLUGIN_ID),
            'respectful' => __('Respectful', Aysa::PLUGIN_ID),
            'assertive' => __('Assertive', Aysa::PLUGIN_ID),
            'conversational' => __('Conversational', Aysa::PLUGIN_ID),
        ];
    }

    public function load_template_part( $path, $args = array() ) {
        if ( ! empty( $args ) && is_array( $args ) ) {
            extract( $args, EXTR_SKIP );
        }

        include( $path );
    }
}