<?php

namespace Aysa\App\Helpers;

class Validator
{
    public function validate_email($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    public function validate_required($data, $requiredValues)
    {
        foreach ($requiredValues as $value) {
            if (empty($data[$value])) {
                return false;
            }
        }

        return true;
    }

    public function validate_url($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        return true;
    }

    public function validate_number($number)
    {
        if (!filter_var($number, FILTER_VALIDATE_INT)) {
            return false;
        }

        return true;
    }

    public function validate_phone($phone)
    {
        if (!preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $phone)) {
            return false;
        }

        return true;
    }

    public function sanitize($field, $type)
    {
        if($type == 'text'){
           return sanitize_text_field($field);
        }

        if($type == 'email'){
            return sanitize_email($field);
        }

        if ($type == 'url') {
            return esc_url_raw($field);
        }

        if ($type == 'number') {
            return intval($field);
        }

        return sanitize_text_field($field);
    }
}