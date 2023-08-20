<?php

namespace App\Http\Controllers\Admin;

use App\Models\Group as Model;
use App\Http\Requests\GroupRequest as Request;

class GroupCrudController extends BaseCrudController
{
    use Resources\Group\Main;

    protected $model   = Model::class;
    protected $request = Request::class;
}
