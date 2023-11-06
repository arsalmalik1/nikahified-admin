<?php
/**
 * PaymentEngine.php - Main component file
 *
 * This file is part of the Payment component.
 *-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\User;

use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Components\Plan\Models\PlanModel;
use App\Yantrana\Components\User\Interfaces\PaymentEngineInterface;
use App\Yantrana\Components\User\Models\UserPayment;
use App\Yantrana\Components\User\Models\UserSubscription;
use App\Yantrana\Components\User\Repositories\PaymentRepository;
use App\Yantrana\Components\User\Repositories\UserRepository;
use Carbon\Carbon;

class PaymentEngine extends BaseEngine implements PaymentEngineInterface
{
    /**
     * @var  PaymentRepository - Payment Repository
     */
    protected $paymentRepository;

    /**
     * @var UserRepository - User Repository
     */
    protected $userRepository;

    /**
     * Constructor
     *
     * @param  PaymentRepository  $paymentRepository - Payment Repository
     * @return  void
     *-----------------------------------------------------------------------*/
    public function __construct(
        PaymentRepository $paymentRepository,
        UserRepository $userRepository
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * get payment list data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function preparePaymentList()
    {
        $paymentCollection = $this->paymentRepository->fetchAllPayment();

        $paymentData = [];
        if (! __isEmpty($paymentCollection)) {
            foreach ($paymentCollection as $key => $payment) {
                $paymentData[] = [
                    '_id' => $payment['_id'],
                    '_uid' => $payment['_uid'],
                    'title' => $payment['title'],
                    'price' => intval($payment['price']),
                    'description' => $payment['description'],
                    'duration' => $payment['duration'],
                    'created_at' => formatDate($payment['created_at']),
                    'updated_at' => formatDate($payment['updated_at'])
                ];
            }
        }
        //success response
        return $this->engineReaction(1, [
            'paymentData' => $paymentData,
        ]);
    }


    /**
     * get Api notification list data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function prepareApiPaymentList($user_id)
    {
        $paymentCollection = $this->paymentRepository->fetchApiPaymentListData($user_id);
        $requireColumns = [
            '_id',
            '_uid',
            'user__id',
            'plan_id',
            'amount',
            'currency',
            'status',
            'payment_gateway',
            'created_at' => function ($pageData) {
                return formatDate($pageData['created_at']);
            },
            'updated_at' => function ($pageData) {
                return formatDate($pageData['updated_at']);
            },
        ];

        return $this->customTableResponse($paymentCollection, $requireColumns);
    }

    /**
     * Process user update password request.
     *
     * @param  array  $inputData
     * @return array
     *---------------------------------------------------------------- */
    public function processCreatePayment($inputData)
    {
        $chargeId = $inputData['payment_intent_id'];
        $amount = ($inputData['amount'] > 0) ? ($inputData['amount']/100) : 0;
        $currency = $inputData['currency'];
        $chargedAt = $inputData['charge_created'];
        $planId = $inputData['plan_id'];
        $userId = $inputData['user_id'];

        $paymentCount = UserPayment::where('sale_id', $chargeId)->count();
        if($paymentCount == 0){

            // Example: Log the charge information
            \Log::info('Charge ID: ' . $chargeId . ', Amount: ' . $amount . ', Currency: ' . $currency);

            // Additional operations based on the charge.succeeded event
            // Your handling logic here...
            $plan = PlanModel::find($planId);
            if($plan){
                // Convert Unix timestamp to a Carbon instance
                $dateTime = Carbon::createFromTimestamp($chargedAt);
                $formattedDate = $dateTime->format('Y-m-d H:i:s');

                $storeData = [
                    'user__id' => $userId,
                    'plan_id' => $planId,
                    'sale_id' => $chargeId,
                    'amount' => $amount,
                    'currency' => $currency,
                    'status' => 'success',
                    'payment_gateway' => 'stripe',
                    'charged_at' => $formattedDate
                ];

                if ($newPayment = $this->paymentRepository->storePayment($storeData)) {
                    //return $this->engineReaction(1, [], __tr('Payment added successfully.'));

                    // Cancel existing active subscription
                    $this->processCancelSubscription($userId);

                    // Create new subscription
                    $expiryAt = now()->addDays($plan->duration)->format("Y-m-d H:i:s");
                    $subscriptionData = [
                        'expiry_at' => $expiryAt,
                        'users__id' => $userId,
                        'status' => 1,
                        'payment_id' => $newPayment->_id,
                        'plan_id' => $planId,
                        'plan_name' => $plan->title,
                        'price' => $plan->price,
                        'duration' => $plan->duration,
                        'description' => $plan->description
                    ];

                    if ($newSubscription = $this->paymentRepository->storeSubscription($subscriptionData)) {
                        return $this->engineReaction(1, [], __tr('User payment saved and subscription created successfully.'));
                    }
                    return $this->engineReaction(2, null, __tr('Subscription could not create.'));

                }
                return $this->engineReaction(2, null, __tr('Payment could not add.'));
            }
            return $this->engineReaction(1, ['show_message' => true], __tr('Invalid plan id submitted.'));
        }
        return $this->engineReaction(1, ['show_message' => true], __tr('This sale id already exists.'));
    }

    public function processCancelSubscription($userId){
        $res = UserSubscription::where([['users__id', '=', $userId], ['status', '=', 1]])->update(['status' => 0]);
        if($res){
            return $this->engineReaction(1, ['show_message' => true], __tr('Subscription cancelled successfully.'));
        }
        return $this->engineReaction(1, ['show_message' => true], __tr('Invalid user id submitted.'));
    }

}
