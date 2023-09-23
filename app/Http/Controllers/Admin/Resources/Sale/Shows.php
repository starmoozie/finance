<?php

namespace App\Http\Controllers\Admin\Resources\Sale;

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

        $this->crud->column('products')
            ->label(__('starmoozie::title.details'))
            ->type('view')
            ->view('starmoozie::crud.pages.transaction.details')
            ->after('total_nominal');
    }
}
