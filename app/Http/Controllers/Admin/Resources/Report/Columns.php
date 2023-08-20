<?php

namespace App\Http\Controllers\Admin\Resources\Report;

trait Columns
{
    /**
     * Define create / update form fields.
     * 
     * @return void
     */
    protected function setColumns()
    {
        $this->crud->column('debit')
            ->label(__('starmoozie::title.income'));

        $this->crud->column('credit')
            ->label(__('starmoozie::title.expense'));

        $this->crud->column('created_at')
            ->label(__('starmoozie::title.created'))
            ->type('date');
    }
}
