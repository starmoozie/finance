<?php

namespace App\Http\Requests;

use App\Rules\CheckIfQtyNotMoreThanStockRule;
use Illuminate\Validation\Rule;
use App\Models\Product;

class SaleRequest extends BaseRequest
{
    const MIN = 0;
    const MAX = 15;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'details' => [
                'required',
                'array',
            ],
            'details.*.product_id' => [
                'required',
                Rule::exists(Product::class, 'id')
            ],
            'details.*.qty' => [
                'required',
                'not_in:' . Self::MIN,
                'digits_between:1,' . Self::MAX,
                new CheckIfQtyNotMoreThanStockRule(request()->details)
            ]
        ];
    }

    public function messages()
    {
        return [
            'details.*.product_id.exists'  => __('validation.exists', ['attribute' => __('starmoozie::title.product')]),
            'details.*.qty.not_in'         => __('validation.gt.numeric', ['attribute' => __('starmoozie::title.qty'), 'value' => Self::MIN]),
            'details.*.qty.digits_between' => __('validation.max.digits', ['attribute' => __('starmoozie::title.qty'), 'value' => Self::MAX]),
        ];
    }
}
