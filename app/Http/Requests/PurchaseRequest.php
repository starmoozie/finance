<?php

namespace App\Http\Requests;

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
            ],
            'details.*.sub_total' => [
                'required',
                'regex:/[0-9]{3,15}/',
            ]
        ];
    }
}
