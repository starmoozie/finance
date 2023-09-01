<?php

namespace App\Http\Requests;

use App\Rules\CheckProfitRule;
use Illuminate\Validation\Rule;
use App\Models\Product;

class PurchaseRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'details.*' => [
                'required',
                'array'
            ],
            'details.*.qty' => [
                'required',
                'regex:/[0-9]{1,15}/'
            ],
            'details.*.sub_total' => [
                'required',
                'regex:/[0-9]{3,15}/'
            ],
            'details.*.type_profit' => [
                'required',
                'boolean'
            ],
            'details.*.profit' => [
                'required'
            ]
        ];
    }
}
