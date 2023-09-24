<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Models\ProductCategory;

class ProductCategoryRequest extends BaseRequest
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
                'max:30',
                Rule::unique(ProductCategory::class)->when($this->method() === 'PUT', fn($q) => $q->ignore(request()->id))
            ],
        ];
    }
}
