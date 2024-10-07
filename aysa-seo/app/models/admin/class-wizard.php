<?php

namespace Aysa\App\Models\Admin;

use Aysa\App\Exceptions\Invalid_Data_Exception;
use Aysa\App\Helpers\Settings;
use Aysa\App\Helpers\Validator;

if (!class_exists(__NAMESPACE__ . '\\' . 'Wizard')) {

    class Wizard extends Base_Model
    {
        private Validator $validator;

        public function __construct(Validator $validator = null)
        {
            $this->validator = $validator ?? new Validator();
        }

        public function save($data, $option_name)
        {
            $this->sanitize($data);
            $this->validate($data, $option_name);
            $this->save_settings($data, $option_name);
        }

        private function validate($data, $step)
        {
            if ($step == Settings::GENERAL_SETTINGS_NAME) {
                return $this->validate_general_information($data);
            }
            if($step == Settings::OBJECTIVES_SETTINGS_NAME) {
                return $this->validate_objectives($data);
            }
            if ($step == Settings::SEO_SETTINGS_NAME) {
                return $this->validate_seo_settings($data);
            }

            return true;
        }

        /**
         * @param array $data
         *
         * @return bool
         * @throws Invalid_Data_Exception
         */
        private function validate_general_information(array $data)
        {
            $requiredValues = [
                'aysa-company-name', 'aysa-email', 'aysa-website', 'aysa-telephone', 'aysa-website-type', 'aysa-industry'
            ];

            $requiredValues = $this->validator->validate_required($data, $requiredValues);

            if($data['aysa-website-type'] == 'online_store') {
                $requiredValues = $this->validator->validate_required($data, ['aysa-store-shipping', 'aysa-store-payment']);
            }

            if (!$requiredValues) {
                throw new Invalid_Data_Exception('Please fill all the required fields.');
            }

            if ($data['aysa-email'] && !$this->validator->validate_email($data['aysa-email'])) {
                throw new Invalid_Data_Exception('Invalid email');
            }

            if($data['aysa-website'] && !$this->validator->validate_url($data['aysa-website'])){
                throw new Invalid_Data_Exception('Invalid website');
            }

            if($data['aysa-telephone'] && !$this->validator->validate_number($data['aysa-telephone'])){
                throw new Invalid_Data_Exception('Invalid telephone');
            }

            return true;
        }

        private function validate_objectives($data)
        {
            $requiredValues = ['aysa-goals'];
            $requiredValues = $this->validator->validate_required($data, $requiredValues);

            if (!$requiredValues) {
                throw new Invalid_Data_Exception('Please fill all the required fields.');
            }

            if(is_array($data['aysa-goals']) && count($data['aysa-goals']) > 3){
                throw new Invalid_Data_Exception('Please choose between one and three objectives.');
            }

            return true;
        }

        private function validate_seo_settings($data)
        {
            $requiredValues = [
                'targeted_se',
                'targeted_country',
                'targeted_region',
                'targeted_city',
                'targeted_brand',
                'language-optimize',
                'update_frequency'
                ];

            $requiredValues = $this->validator->validate_required($data, $requiredValues);

            if (!$requiredValues) {
                throw new Invalid_Data_Exception('Please fill all the required fields.');
            }

            return true;
        }

        private function sanitize($data)
        {
            $email_fields = ['aysa-email'];
            $url_fields = ['aysa-website'];
            $telephone_fields = ['aysa-telephone'];

            foreach ($data as $key => $value) {
                if(in_array($key, $email_fields)){
                    $data[$key] = $this->validator->sanitize($value, 'email');
                    continue;
                }
                if(in_array($key, $url_fields)){
                    $data[$key] = $this->validator->sanitize($value, 'url');
                    continue;
                }
                if(in_array($key, $telephone_fields)){
                    $data[$key] = $this->validator->sanitize($value, 'number');
                    continue;
                }

                $data[$key] = $this->validator->sanitize($value, 'text');
            }
        }


        private function save_settings($data, $option_name)
        {
            $settings = $this->get_settings_class($option_name);
            $settings->save_settings($data);
        }

        public function get_settings_class($option_name)
        {
            return new Settings($option_name);
        }
    }
}
