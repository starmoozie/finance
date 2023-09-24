<?php

namespace App\Http\Requests;

use App\Constants\LengthContant;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $is_update   = $this->method() === "PUT";
        $id          = request()->id;
        $max_numeric = LengthContant::MAX_NUMERIC;

        return [
            'name' => [
                'max:' . LengthContant::MAX_NAME,
                'required',
                'regex:/^[a-z A-Z]+$/'
            ],
            'email' => [
                'max:' . LengthContant::MAX_NAME,
                'required',
                'email',
                Rule::unique(User::class)->when($is_update, fn($q) => $q->ignore($id))
            ],
            'mobile' => [
                'required',
                "regex:/(08)[0-9]{6,$max_numeric}/",
                Rule::unique(User::class)->when($is_update, fn($q) => $q->ignore($id))
            ],
            'password' => $is_update ? 'confirmed' : 'required|confirmed',
            'role' => 'required'
        ];
    }
}
