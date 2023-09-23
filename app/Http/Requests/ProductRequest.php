<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Models\Product;

class ProductRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'code' => [
            //     'required',
            //     'max:20',
            //     Rule::unique(Product::class)->when($this->method() === 'PUT', fn($q) => $q->ignore(request()->id))
            // ],
            'name' => [
                'required',
                'max:50',
                Rule::unique(Product::class)->when($this->method() === 'PUT', fn($q) => $q->ignore(request()->id))
            ],
        ];
    }
}
