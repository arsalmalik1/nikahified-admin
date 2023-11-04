<?php
/**
* StripeWebhookController.php - Controller file
*
* This file is part of the StripeWebhook User component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\User\ApiControllers;

use App\Yantrana\Base\BaseController;
// form Requests
use App\Yantrana\Components\Plan\Models\PlanModel;
use App\Yantrana\Components\User\Models\UserPayment;
use App\Yantrana\Components\User\Models\UserSubscription;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends BaseController
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $secret = getenv('STRIPE_SECRET');
        //echo $secret; echo '<br>';
        //print_r($request->header('stripe-signature')); exit;
        // You can log the entire payload for inspection
        \Log::info('Stripe Webhook Payload: ' . $payload);

        // Verify the Stripe signature if required
        try {
            $event = Webhook::constructEvent(
                $payload,
                $request->header('stripe-signature'),
                $secret
            );

            // Event verified, process the event
            // For example, $event->type will contain the event type

            // Parse the JSON payload
            $data = json_decode($payload, true);

            // Check if it's a charge.succeeded event
            if ($data['type'] === 'charge.succeeded') {
                $chargeData = $data['data']['object'];
                $chargeId = $chargeData['id'];
                $payment = UserPayment::where('sale_id', $chargeId)->first();
                if($payment){
                    $payment->status = 'success';
                    $payment->save();
                    UserSubscription::where('payment_id', $payment->_id)->update(['status' => 1]);
                }

            }
            else if($data['type'] === 'charge.failed') {
                $chargeData = $data['data']['object'];
                $chargeId = $chargeData['id'];
                $payment = UserPayment::where('sale_id', $chargeId)->first();
                if($payment){
                    $payment->status = 'failed';
                    $payment->save();
                    UserSubscription::where('payment_id', $payment->_id)->update(['status' => 0]);
                }
            }

            \Log::info('Stripe webhook handled: ' . $event->id);
            return response()->json(['success' => true]);

        } catch (SignatureVerificationException $e) {
            // Invalid signature
            \Log::warning('Stripe webhook signature verification failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Not authorized'])->setStatusCode(400);
        }
    }
}
