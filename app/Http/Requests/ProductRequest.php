<?php

namespace App\Http\Requests;

use App\Constants\LengthContant;
use Illuminate\Validation\Rule;
use App\Models\{
    Product,
    ProductCategory
};

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
            'code' => [
                'sometimes',
                'nullable',
                'max:' . LengthContant::MAX_CODE,
                Rule::unique(Product::class)->when($this->method() === 'PUT', fn($q) => $q->ignore(request()->id))
            ],
            'product_category_id' => [
                'sometimes',
                'nullable',
                Rule::exists(ProductCategory::class, 'id')
            ],
            'name' => [
                'required',
                'max:' . LengthContant::MAX_NAME,
                Rule::unique(Product::class)->when($this->method() === 'PUT', fn($q) => $q->ignore(request()->id))
            ],
        ];
    }
}
