<?php

namespace Aysa\App\Controllers\Admin;

class Get_Suggestions extends Base_Controller
{
    public function register_hook_callbacks()
    {
        add_action('wp_ajax_get_aysa_suggestions', [$this, 'get_aysa_suggestions']);
        add_action('wp_ajax_nopriv_get_aysa_suggestions', [$this, 'get_aysa_suggestions']);

        add_action('wp_ajax_get_aysa_saved_suggestions', [$this, 'get_aysa_saved_suggestions']);
        add_action('wp_ajax_nopriv_get_aysa_saved_suggestions', [$this, 'get_aysa_saved_suggestions']);
    }

    public function get_aysa_suggestions()
    {
        try {
            $requestData = $_GET['data'];

            if (empty($requestData) || empty($requestData['entity_id']) || empty($requestData['type'])) {
                throw new \Exception('Invalid request. Missing required parameters.');
            }

            $data = $this->model->get_aysa_suggestions($requestData['entity_id'], $requestData['type']);
            if (!$data) {
                throw new \Exception('No data available.');
            }

            $response = array(
                'status' => 'success',
                'message' => 'SEO suggestions fetched successfully',
                'data' => $data
            );
        } catch (\Exception $e) {
            $response = array(
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => null
            );
        }

        wp_send_json($response);
        exit();
    }

    public function get_aysa_saved_suggestions()
    {
        try {
            $requestData = $_GET['data'];

            if (empty($requestData) || empty($requestData['entity_id']) || empty($requestData['type'])) {
                throw new \Exception('Invalid request. Missing required parameters.');
            }

            $data = $this->model->get_aysa_saved_suggestions($requestData['entity_id'], $requestData['type']);

            if (!$data) {
                throw new \Exception('No data available.');
            }

            $response = array(
                'status' => 'success',
                'message' => 'SEO suggestions fetched successfully',
                'data' => $data
            );

        } catch (\Exception $e) {
            $status = 'error';
            if($e->getMessage() == 'No data available.'){
                $status = 'no-data';
            }

            $response = array(
                'status' => $status,
                'message' => $e->getMessage(),
                'data' => null
            );
        }

        wp_send_json($response);
        exit();
    }
}
