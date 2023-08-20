<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction as Model;
use App\Http\Requests\IncomeRequest as Request;
use App\Constants\TransactionConstant;

class IncomeCrudController extends BaseCrudController
{
    use Resources\Income\Main;

    protected $model   = Model::class;
    protected $request = Request::class;
    protected $scopes  = [
        'income'
    ];

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->addRequest($this->crud->getRequest(), ['created_by' => starmoozie_user()->id, 'type' => TransactionConstant::INCOME]);

        return $this->traitStore();
    }
}
