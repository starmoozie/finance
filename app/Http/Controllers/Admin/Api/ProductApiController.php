<?php

namespace App\Http\Controllers\Admin\Api;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends BaseApiController
{
    protected $model   = Product::class;
    protected $columns = [
        "name",
        "code"
    ];

    function fetchAll(Request $request)
    {
        return (new $this->model)
            ->when($request->q, function($query) use($request) {
                foreach ($this->columns as $key => $column) {
                    $fn = !$key ? 'where' : 'orWhere';
                    $query->{$fn}($column, "LIKE", "%{$request->q}%");
                }

                return $query;
            })
            ->hasStock()
            ->paginate(10);
    }
}
