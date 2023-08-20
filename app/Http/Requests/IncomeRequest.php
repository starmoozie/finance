<?php

namespace App\Http\Requests;

class IncomeRequest extends BaseRequest
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
            'details.*.nominal' => [
                'required',
                'regex:/[0-9]{3,15}/',
            ]
        ];
    }
}
