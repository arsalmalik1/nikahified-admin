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

class StripeWebhookController extends BaseController
{
    public function handleWebhook(Request $request)
    {
        // Verify the Stripe signature if required

        // Retrieve the JSON payload from the request
        $payload = $request->getContent();

        // You can log the entire payload for inspection
        \Log::info('Stripe Webhook Payload: ' . $payload);

        // Parse the JSON payload
        $data = json_decode($payload, true);

        // Check if it's a charge.succeeded event
        if ($data['type'] === 'charge.succeeded') {
            // Access charge data
            /*$chargeData = $data['data']['object'];

            $chargeId = $chargeData['id'];
            $amount = $chargeData['amount'];
            $currency = $chargeData['currency'];
            $customerId = $chargeData['customer'];
            $chargedAt = $chargeData['created'];

            $paymentCount = UserPayment::where('sale_id', $chargeId)->count();
            if($paymentCount == 0){
                $planId = 0;
                $userId = 0;
                // Access the metadata if present
                if (isset($chargeData['metadata'])) {
                    $customMetadata = $chargeData['metadata'];
                    $planId = $customMetadata['plan_id'];
                    $userId = $customMetadata['user_id'];
                }

                // Convert Unix timestamp to a Carbon instance
                $dateTime = Carbon::createFromTimestamp($chargedAt);
                $formattedDate = $dateTime->format('Y-m-d H:i:s');

                // Example: Log the charge information
                \Log::info('Charge ID: ' . $chargeId . ', Amount: ' . $amount . ', Currency: ' . $currency);

                // Additional operations based on the charge.succeeded event
                // Your handling logic here...
                $plan = PlanModel::find($planId);
                if($plan){

                    $paymentData = [
                        'user__id' => $userId,
                        'customer_id' => $customerId,
                        'plan_id' => $planId,
                        'sale_id' => $chargeId,
                        'amount' => $amount,
                        'currency' => $currency,
                        'status' => 'success',
                        'payment_gateway' => 'stripe',
                        'charged_at' => $formattedDate
                    ];
                    $paymentId = UserPayment::insertGetId($paymentData);
                    $subscription = UserSubscription::where('users__id', $userId)->first();
                    $expiryAt = now()->addMonths($plan->duration)->format("Y-m-d H:i:s");
                    $subscriptionData = [
                        'plan_id' => $planId,
                        'expiry_at' => $expiryAt,
                        'users__id' => $userId,
                        'status' => 1,
                        'payment_id' => $paymentId
                    ];
                    if($subscription){
                        UserSubscription::where('users__id', $userId)->update($subscriptionData);
                    }
                    else{
                        UserSubscription::insert($subscriptionData);
                    }
                }
            }*/

        }
        else if($data['type'] === 'charge.failed') {

        }

        return response()->json(['success' => true]);
    }
}
