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
    protected $primaryModel = UserPayment::class;

    /**
     * Fetch the record of Payment
     *
     * @param    int || string $idOrUid
     * @return    eloquent collection object
     *---------------------------------------------------------------- */
    public function fetch($idOrUid)
    {
        if (is_numeric($idOrUid)) {
            return UserPayment::where('_id', $idOrUid)->first();
        }

        return UserPayment::where('_uid', $idOrUid)->first();
    }

    /**
     * fetch all plan list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchAllPayment()
    {
        return UserPayment::get();
    }

    /**
     * fetch all active plan list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchAllActiveCreditPayment()
    {
        return UserPayment::where('status', 1)
            ->get();
    }

    /**
     * store new payment.
     *
     * @param  array  $input
     * @return mixed
     *---------------------------------------------------------------- */
    public function storePayment($input)
    {
        $keyValues = [
            'user__id',
            'payment_intent_id',
            'plan_id',
            'sale_id',
            'amount',
            'currency',
            'status',
            'payment_gateway',
            'charged_at'
        ];
        $payment = new UserPayment;
        // Store New plan
        if ($payment->assignInputsAndSave($input, $keyValues)) {
            //payment add activity log
            activityLog('Payment created. ');

            return $payment;
        }

        return false;
    }

    /**
     * store new subscription.
     *
     * @param  array  $input
     * @return mixed
     *---------------------------------------------------------------- */
    public function storeSubscription($input)
    {
        $keyValues = [
            'expiry_at',
            'users__id',
            'status',
            'payment_id',
            'plan_id',
            'plan_name',
            'price',
            'duration',
            'description'
        ];
        $subscription = new UserSubscription();
        // Store New Subscription
        if ($subscription->assignInputsAndSave($input, $keyValues)) {
            //payment add activity log
            activityLog('Subscription created. ');

            return $subscription;
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
