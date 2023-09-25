<?php

namespace App\Http\Requests;

use App\Constants\LengthContant;

class SellerRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'max:' . LengthContant::MAX_NAME
            ],
        ];
    }
}
