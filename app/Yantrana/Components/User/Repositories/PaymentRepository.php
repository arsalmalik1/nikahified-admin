<?php
/**
* PaymentRepository.php - Repository file
*
* This file is part of the Payment component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\User\Repositories;

use App\Yantrana\Base\BaseRepository;
use App\Yantrana\Components\User\Interfaces\PaymentRepositoryInterface;
use App\Yantrana\Components\User\Models\UserPayment;
use App\Yantrana\Components\User\Models\UserSubscription;

class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{
        /**
     * primary model instance
     * eg. YourModelModel::class;
     *
     * @var object
     */
    protected $primaryModel = PaymentModel::class;

    /**
     * Fetch the record of Payment
     *
     * @param    int || string $idOrUid
     * @return    eloquent collection object
     *---------------------------------------------------------------- */
    public function fetch($idOrUid)
    {
        if (is_numeric($idOrUid)) {
            return PaymentModel::where('_id', $idOrUid)->first();
        }

        return PaymentModel::where('_uid', $idOrUid)->first();
    }

    /**
     * fetch all plan list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchAllPayment()
    {
        return PaymentModel::get();
    }

    /**
     * fetch all active plan list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchAllActiveCreditPayment()
    {
        return PaymentModel::where('status', 1)
            ->get();
    }

    /**
     * store new plan.
     *
     * @param  array  $input
     * @return mixed
     *---------------------------------------------------------------- */
    public function storePayment($input)
    {
        $keyValues = [
            'title',
            'price',
            'description',
            'duration'
        ];
        $plan = new PaymentModel;
        // Store New plan
        if ($plan->assignInputsAndSave($input, $keyValues)) {
            //plan add activity log
            activityLog($plan->title.' plan created. ');

            return $plan;
        }

        return false;
    }

    /**
     * Update Payment Data
     *
     * @param  object  $planData
     * @return bool
     *---------------------------------------------------------------- */
    public function updatePayment($planData, $updateData)
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
     * fetch all pages list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchApiPaymentListData()
    {
        $dataTableConfig = [
            'searchable' => [],
        ];

        return UserPayment::select('*')
            ->latest()
            ->customTableOptions($dataTableConfig);
    }

}
