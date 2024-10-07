<?php

namespace Aysa\App\Controllers\Cron;

use Aysa\App\Helpers\Get_Ranks_Service;
use Aysa\Core\Model;

class Get_Ranks_Cron extends \Aysa\Core\Controller
{
    private Get_Ranks_Service $get_ranks_service;

    public function __construct(
        Model $model,
        $view = false,
        Get_Ranks_Service $get_ranks_service = null

    ) {
        $this->get_ranks_service = $get_ranks_service ?? new Get_Ranks_Service();

        parent::__construct($model, $view);
    }

    public function register_hook_callbacks()
    {
//        add_action('get_ranks_cron', [$this, 'get_ranks']);
//        wp_schedule_event(time(), 'twicedaily', 'get_ranks_cron');
    }

    public function get_ranks()
    {
        //TODO create a cron that runs twice a day and looks though all the data in the rank tracker table
        //based on the values on the frequency and last time that it ran do a call to the api to udate the data

        try{
            $this->get_ranks_service->run_by_schedule();
        }catch (\Exception $e){
            error_log($e->getMessage());
        }
    }
}