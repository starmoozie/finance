<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction as Model;
use App\Http\Requests\ExpenseRequest as Request;

class ExpenseCrudController extends BaseCrudController
{
    use Resources\Expense\Main;

    protected $model   = Model::class;
    protected $request = Request::class;
    protected $scopes  = [
        'expense'
    ];

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->addRequest($this->crud->getRequest(), ['created_by' => starmoozie_user()->id]);

        return $this->traitStore();
    }
}
