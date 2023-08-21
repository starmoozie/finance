<?php

namespace App\Http\Controllers\Admin\Resources\Product;
use Spatie\Activitylog\Models\Activity;

trait Shows
{
    /**
     * Define create / update form fields.
     * 
     * @return void
     */
    protected function setShows()
    {
        $this->setColumns();

        $this->crud->column('transactions')
            ->type('view')
            ->view('starmoozie::crud.pages.product.transaction');

        $this->crud->column('histories')
            ->type('view')
            ->view('starmoozie::crud.pages.product.history');
    }
}
