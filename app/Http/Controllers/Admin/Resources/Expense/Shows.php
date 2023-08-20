<?php

namespace App\Http\Controllers\Admin\Resources\Expense;

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
        $this->crud->column('details')
            ->type('view')
            ->view('starmoozie::crud.pages.transaction.details')
            ->after('total_nominal');
    }
}
