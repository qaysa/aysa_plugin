<?php

namespace Aysa\App\Helpers;

use Aysa\App\Models\Admin\Get_Ranks;
use Aysa\App\Models\Data\Repository\Rank_Tracker_Repository;

class Get_Ranks_Service
{
    private $rank_tracker_repository;

    private $get_ranks;

    public function __construct(
        Rank_Tracker_Repository $rank_tracker_repository = null,
        Get_Ranks $get_ranks = null
    )
    {
        $this->rank_tracker_repository = $rank_tracker_repository ?? new Rank_Tracker_Repository();
        $this->get_ranks = $get_ranks ?? new Get_Ranks();
    }

    public function run_by_schedule()
    {
        //TODO how can this be done in batches?

        //TODO get all by schedule date
        $ranks = $this->rank_tracker_repository->get_by_schedule();

        //the ones for witch the scheduled date has passed will be run, all together
        //then they will be updated with the new scheduled date and the last running date

        $req_ids_list = [];
        foreach ($ranks as $rank) {
            $req_ids_list[] = $rank->get_aysa_keyword_id();
        }

        $result = $this->get_ranks->get_ranks(['req_ids_list' => $req_ids_list]);

        //        {
        //    "203": {
        //        "current_rank": "0",
        //        "old_rank": "0",
        //        "aysa_score": 97
        //    },
        //    "206": {
        //        "current_rank": "4",
        //        "old_rank": "3",
        //        "aysa_score": 14
        //    },
        //    "207": {
        //        "current_rank": "8",
        //        "old_rank": "6",
        //        "aysa_score": 50
        //    }
        //}

        foreach ($result as $rank) {
            $this->rank_tracker_repository->get_by_keyword($rank['keyword_id']);
            $this->rank_tracker_repository->update_rank($rank);
        }
    }
}