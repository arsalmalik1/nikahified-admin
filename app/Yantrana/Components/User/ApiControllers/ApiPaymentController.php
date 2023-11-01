<?php
/**
 * ApiPaymentController.php - Controller file
 *
 * This file is part of the Payment component.
 *-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\User\ApiControllers;

use App\Yantrana\Base\BaseController;
use App\Yantrana\Components\User\PaymentEngine;
use App\Yantrana\Components\User\Requests\StripePaymentRequest;
use Illuminate\Support\Facades\Request;

class ApiPaymentController extends BaseController
{
    /**
     * @var PaymentEngine - Payment Engine
     */
    protected $paymentEngine;

    /**
     * Constructor.
     *
     * @param  PaymentEngine  $paymentEngine - Payment Engine
     *-----------------------------------------------------------------------*/
    public function __construct(PaymentEngine $paymentEngine)
    {
        $this->paymentEngine = $paymentEngine;
    }

    /**
     * Get Payment DataTable data.
     *
     *-----------------------------------------------------------------------*/
    public function getUserPayment(Request $request, $user_id = null)
    {
        return $this->paymentEngine->prepareApiPaymentList($user_id);
    }

    /**
     * Get Payment DataTable data.
     *
     *-----------------------------------------------------------------------*/
    public function createUserPayment(StripePaymentRequest $request)
    {
        $processReaction = $this->paymentEngine->processCreatePayment($request->all());
        return $this->processResponse($processReaction, [], [], true);
    }
}
