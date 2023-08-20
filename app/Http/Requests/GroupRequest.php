<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Models\Group;

class GroupRequest extends BaseRequest
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
                'max:50',
                Rule::unique(Group::class)->when($this->method() === 'PUT', fn($q) => $q->ignore(request()->id))
            ]
        ];
    }
}
