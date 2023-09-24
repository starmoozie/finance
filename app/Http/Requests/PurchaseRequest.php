<?php

namespace App\Http\Requests;

use App\Rules\CheckAmountProfitRule;
use App\Constants\LengthContant;
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
        $max_numeric = LengthContant::MAX_NUMERIC;

        return [
            'details.*' => [
                'required',
                'array'
            ],
            'details.*.product_id' => [
                'required',
                Rule::exists(Product::class, 'id')
            ],
            'details.*.qty' => [
                'required',
                "regex:/[0-9]{1,$max_numeric}/"
            ],
            'details.*.total_price' => [
                'required',
                "regex:/[0-9]{1,$max_numeric}/"
            ],
            'details.*.type_profit' => [
                'required',
                'boolean'
            ],
            'details.*.amount_profit' => [
                'required',
                new CheckAmountProfitRule(request()->details)
            ]
        ];
    }
}
