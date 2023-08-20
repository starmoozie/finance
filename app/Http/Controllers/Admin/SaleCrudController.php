<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction as Model;
use App\Http\Requests\SaleRequest as Request;
use App\Constants\TransactionConstant;

class SaleCrudController extends BaseCrudController
{
    use Resources\Sale\Main;

    protected $model   = Model::class;
    protected $request = Request::class;
    protected $scopes  = [
        'sale'
    ];

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->addRequest($this->crud->getRequest(), ['created_by' => starmoozie_user()->id, 'type' => TransactionConstant::SALE]);

        return $this->traitStore();
    }
}
