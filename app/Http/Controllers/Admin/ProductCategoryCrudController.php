<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductCategory as Model;
use App\Http\Requests\ProductCategoryRequest as Request;

class ProductCategoryCrudController extends BaseCrudController
{
    use Resources\ProductCategory\Main;

    protected $model   = Model::class;
    protected $request = Request::class;
}
