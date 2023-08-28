<?php

namespace App\Http\Controllers\Admin\Api;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends BaseApiController
{
    protected $model  = Product::class;
    protected $column = "name";

    function fetchAll(Request $request)
    {
        return (new $this->model)
            ->when($request->q, fn($q) => $q->where($this->column, "LIKE", "%{$request->q}%"))
            ->paginate(10);
    }
}
