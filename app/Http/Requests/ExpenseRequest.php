<?php

namespace App\Http\Requests;

use App\Constants\LengthContant;

class ExpenseRequest extends BaseRequest
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
            ],
            'details.*.total_price' => [
                'required',
                "regex:/[0-9]{3,$max_numeric}/",
            ]
        ];
    }
}
