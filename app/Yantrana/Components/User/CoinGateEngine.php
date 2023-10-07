<?php

namespace App\Yantrana\Components\User;

use App\Yantrana\Base\BaseEngine;
use Illuminate\Support\Facades\Http;
use App\Yantrana\Components\User\Models\CreditWalletTransaction;
use App\Yantrana\Components\FinancialTransaction\Models\FinancialTransaction;
use App\Yantrana\Components\FinancialTransaction\Repositories\FinancialTransactionRepository;


class CoinGateEngine extends BaseEngine
{

    /**
     * @var paymentUrl - paymentUrl
     */
    protected $paymentUrl;
    /**
     *
     * @var financialTransactionRepository - financialTransactionRepository
     */
    protected $financialTransactionRepository;

    /**
     * @var coingateToken - coingateToken
     * @var FinancialTransactionRepository - financialTransactionRepository
     */
    protected $coingateToken;

    public function __construct(FinancialTransactionRepository $financialTransactionRepository)
    {
        if (getStoreSettings('use_test_coingate')) {
            $this->coingateToken = getStoreSettings('coingate_test_token');
            $this->paymentUrl        = 'https://api-sandbox.coingate.com/v2/orders';
        } else {
            $this->coingateToken = getStoreSettings('coingate_live_token');
            $this->paymentUrl        = 'https://api.coingate.com/v2/orders';
        }

        $this->financialTransactionRepository = $financialTransactionRepository;
    }



    public function processCoinGateCheckout($inputData, $orderId)
    {
        $amount = $inputData['amount'];

        $success_url = route('user.credit_wallet.coingate.success', ['status' => 'success']); // success_url

        $cancel_url = route('user.credit_wallet.coingate.success', ['status' => 'cancel']); // cancel_url

        $callback_url = route('user.credit_wallet.write.coingate.callback_url'); // callbackUrl

        // $callback_url = "https://416a-2401-4900-1c8f-367a-69f2-a0f4-e8e4-df00.ngrok-free.app/lw-projects/lw-dating/__CODEFIELD/public/coingate-callback"; // callbackUrl

        $response = Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . $this->coingateToken,
            "Content-Type" => "application/json",
            "Accept" => "application/json"
        ])->post("$this->paymentUrl", [
            "order_id" => $orderId,
            "title" => $inputData['packageName'],
            "price_amount" => $amount,
            "price_currency" => getStoreSettings('currency'),
            "receive_currency" => getStoreSettings('currency'),
            "callback_url" => $callback_url,
            "cancel_url" => $cancel_url,
            "success_url" => $success_url
        ]);

        $result = json_decode($response, true);
        if (isset($result['status']) && $result['status'] == 'new') {
            return $this->engineResponse(1, ['paymentUrl' => $result['payment_url']]);
        } else {
            return $this->engineReaction(2, null, __tr('Fail to Create Payment'));
        }
    }


    /**
     * Capture Coingate Data
     *
     * @return object
     */
    public function captureCoinGateData()
    {
        $payload = @file_get_contents('php://input');

        //converting string to array
        $coingateData = array();
        parse_str($payload, $coingateData);
        var_dump($coingateData);

        // check if status paid or pending
        if (!__isEmpty($coingateData) && $coingateData['status'] == 'paid') {
            // check is already exist or not
            $isAlreadyExist = $this->financialTransactionRepository->fetchIt([
                'txn_id' => $coingateData['id']
            ]);

            //if it is exist then throw error
            if (!__isEmpty($isAlreadyExist)) {
                //success function
                return $this->engineReaction(2, null, __tr('This Transaction is Already Exist'));
            }

            $financialTransactionCollection = $this->financialTransactionRepository->fetch($coingateData['order_id']);
            //if it is empty then throw error
            if (__isEmpty($financialTransactionCollection)) {
                //success function
                return $this->engineReaction(2, null, __tr('Package does not exist.'));
            }

            $data = $financialTransactionCollection->toArray();
            //collect update data
            $updateData = [
                'txn_id' => $coingateData['id'],
                'status' => 2,
                '__data' => [
                    'rawPaymentData' => json_encode($coingateData),
                    'packageName' => $data['__data']['packageName'],
                ],
            ];

            //update transaction process
            if ($this->financialTransactionRepository->updateIt($financialTransactionCollection, $updateData)) {
                //success function
                return $this->engineReaction(1, null, __tr('Purchase successfully'));
            }
        }
        return $this->engineReaction(2, null, __tr('Purchased failed'));
    }



    /**
     * Store new coupon using provided data.
     *
     * @param  array  $inputData
     * @return mixed
     *---------------------------------------------------------------- */
    public function storeTransaction($inputData, $packageData)
    {
        $keyValues = [
            'status',
            'amount',
            'users__id',
            'method',
            'currency_code',
            'is_test',
            'txn_id',
            '__data',
        ];

        $financialTransaction = new FinancialTransaction;

        // Check if new User added
        if ($financialTransaction->assignInputsAndSave($inputData, $keyValues)) {
            //wallet transaction store data
            $keyValues = [
                'status' => 1,
                'users__id' => getUserID(),
                'credits' => (int) $packageData['credits'],
                'financial_transactions__id' => $financialTransaction->_id,
                'credit_type' => 2, //Purchased
            ];

            $CreditWalletTransaction = new CreditWalletTransaction;
            // Check if new User added
            if ($CreditWalletTransaction->assignInputsAndSave([], $keyValues)) {
                return $financialTransaction->_id;
            }
        }

        return false;   // on failed
    }
}
