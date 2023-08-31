<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction as Model;
use App\Http\Requests\ReportRequest as Request;

class ReportCrudController extends BaseCrudController
{
    use Resources\Report\Main;

    protected $model   = Model::class;
    protected $request = Request::class;
    protected $orders  = [
        ['name' => 'created_at', 'type' => 'asc']
    ];
}
