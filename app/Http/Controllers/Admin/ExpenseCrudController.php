<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction as Model;
use App\Http\Requests\ExpenseRequest as Request;
use App\Constants\TransactionConstant;

class ExpenseCrudController extends BaseCrudController
{
    use Resources\Expense\Main;

    protected $model   = Model::class;
    protected $request = Request::class;
    protected $scopes  = [
        'expense',
        'defaultSelectColumnsList'
    ];
    protected $orders  = [
        ['name' => 'updated_at', 'type' => 'desc']
    ];

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @return void
     */
    protected function setupListOperation()
    {
        parent::setupListOperation();

        $this->crud->setOperationSetting('searchableTable', false);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $request   = $this->crud->getRequest();

        $this->addRequest($this->crud->getRequest(), [
            ...['created_by' => starmoozie_user()->id, 'type' => TransactionConstant::EXPENSE],
            ...$this->sumTotalPrice($request->details)
        ]);

        return $this->traitStore();
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $request   = $this->crud->getRequest();

        $this->addRequest($request, $this->sumTotalPrice($request->details));

        return $this->traitUpdate();
    }

    protected function sumTotalPrice($details)
    {
        return ['total_price' => array_sum(array_column($details, 'total_price'))];
    }
}
