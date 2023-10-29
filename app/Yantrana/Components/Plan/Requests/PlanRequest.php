<?php
/**
* PlanRequest.php - Request file
*
* This file is part of the CreditPackage component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Plan\Requests;

use App\Yantrana\Base\BaseRequest;
use Illuminate\Validation\Rule;

class PlanRequest extends BaseRequest
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
     * Get the validation rules that apply to the add author client post request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    public function rules()
    {
        $rules = [
            'title' => [
                'required',
                'min:3',
                'max:150',
                Rule::unique('plans', 'title')->ignore(request()->route('planUId'), '_uid'),
            ],
            'price' => 'required|integer',
            'duration' => 'required|integer',
            'description' => 'required'
        ];

        return $rules;
    }
}
