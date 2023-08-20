<?php

namespace App\Http\Requests;

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
        $is_update = $this->method() === "PUT";
        $id        = request()->id;

        return [
            'name' => [
                'max:50',
                'required',
                'regex:/^[a-z A-Z]+$/'
            ],
            'email' => [
                'max:50',
                'required',
                'email',
                Rule::unique(User::class)->when($is_update, fn($q) => $q->ignore($id))
            ],
            'mobile' => [
                'required',
                'regex:/(08)[0-9]{6,15}/',
                Rule::unique(User::class)->when($is_update, fn($q) => $q->ignore($id))
            ],
            'password' => $is_update ? 'confirmed' : 'required|confirmed',
            'role' => 'required'
        ];
    }
}
