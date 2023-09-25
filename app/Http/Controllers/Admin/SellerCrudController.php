<?php

namespace App\Http\Controllers\Admin;

use App\Models\Seller as Model;
use App\Http\Requests\SellerRequest as Request;

class SellerCrudController extends BaseCrudController
{
    use Resources\Seller\Main;

    protected $model   = Model::class;
    protected $request = Request::class;
}
