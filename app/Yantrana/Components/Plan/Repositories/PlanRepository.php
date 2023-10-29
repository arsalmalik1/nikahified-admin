<?php
/**
* PlanRepository.php - Repository file
*
* This file is part of the Plan component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Plan\Repositories;

use App\Yantrana\Base\BaseRepository;
use App\Yantrana\Components\Plan\Interfaces\PlanRepositoryInterface;
use App\Yantrana\Components\Plan\Models\PlanModel;
use App\Yantrana\Components\User\Models\UserSubscription;

class PlanRepository extends BaseRepository implements PlanRepositoryInterface
{
        /**
     * primary model instance
     * eg. YourModelModel::class;
     *
     * @var object
     */
    protected $primaryModel = PlanModel::class;

    /**
     * Fetch the record of Plan
     *
     * @param    int || string $idOrUid
     * @return    eloquent collection object
     *---------------------------------------------------------------- */
    public function fetch($idOrUid)
    {
        if (is_numeric($idOrUid)) {
            return PlanModel::where('_id', $idOrUid)->first();
        }

        return PlanModel::where('_uid', $idOrUid)->first();
    }

    /**
     * fetch all plan list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchAllPlan()
    {
        return PlanModel::get();
    }

    /**
     * fetch all active plan list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchAllActiveCreditPlan()
    {
        return PlanModel::where('status', 1)
            ->get();
    }

    /**
     * store new plan.
     *
     * @param  array  $input
     * @return mixed
     *---------------------------------------------------------------- */
    public function storePlan($input)
    {
        $keyValues = [
            'title',
            'price',
            'description',
            'duration'
        ];
        $plan = new PlanModel;
        // Store New plan
        if ($plan->assignInputsAndSave($input, $keyValues)) {
            //plan add activity log
            activityLog($plan->title.' plan created. ');

            return $plan;
        }

        return false;
    }

    /**
     * Update Plan Data
     *
     * @param  object  $planData
     * @return bool
     *---------------------------------------------------------------- */
    public function updatePlan($planData, $updateData)
    {
        // Check if information updated
        if ($planData->modelUpdate($updateData)) {
            //plan update activity log
            activityLog($planData->title.' plan updated. ');

            return true;
        }

        return false;
    }

    /**
     * Delete plan.
     *
     * @param  object  $planData
     * @return bool
     *---------------------------------------------------------------- */
    public function delete($planData)
    {
        // Check if plan deleted
        if ($planData->delete()) {
            //plan delete activity log
            activityLog($planData->title.' plan deleted.');

            return  true;
        }

        return false;
    }

    /**
     * fetch all pages list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchApiPlanListData()
    {
        $dataTableConfig = [
            'searchable' => [],
        ];

        return PlanModel::select('*')
            ->latest()
            ->customTableOptions($dataTableConfig);
    }

}
