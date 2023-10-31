<?php
/**
 * PaymentEngine.php - Main component file
 *
 * This file is part of the Payment component.
 *-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\User;

use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Components\User\Interfaces\PaymentEngineInterface;
use App\Yantrana\Components\User\Repositories\PaymentRepository;
use App\Yantrana\Components\User\Repositories\UserRepository;

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

}
