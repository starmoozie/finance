<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product as Model;
use App\Http\Requests\ProductRequest as Request;

class ProductCrudController extends BaseCrudController
{
    use Resources\Product\Main;

    protected $model   = Model::class;
    protected $request = Request::class;
    protected $scopes  = [
        'defaultSelectColumnsList'
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
