<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Models\ProductCategory;
use App\Constants\LengthContant;

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
                'max:' . LengthContant::MAX_NAME,
                Rule::unique(ProductCategory::class)->when($this->method() === 'PUT', fn($q) => $q->ignore(request()->id))
            ],
        ];
    }
}
