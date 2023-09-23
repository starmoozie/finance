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

        $this->crud->column('purchases')
            ->label(__('starmoozie::title.purchase_hitories'))
            ->type('view')
            ->view('starmoozie::crud.pages.transaction.details');

        $this->crud->column('sales')
            ->label(__('starmoozie::title.sale_hitories'))
            ->type('view')
            ->view('starmoozie::crud.pages.transaction.details');
    }
}
