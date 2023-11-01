<?php
/**
* UserSignUpRequest.php - Request file
*
* This file is part of the User component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\User\Requests;

use App\Yantrana\Base\BaseRequest;
use Illuminate\Validation\Rule;

class StripePaymentRequest extends BaseRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the user register request.
     *
     * @return string[]
     *-----------------------------------------------------------------------*/
    public function rules()
    {
        return [
            /*'sale_id' => 'required|unique:user_payments',
            'amount' => 'required|min:3|max:45',
            'currency' => 'required|min:3|max:3',
            'customer_id' => 'required',
            'charge_created' => 'required',
            'plan_id' => 'required',
            'user_id' => 'required',*/
        ];
    }

}
