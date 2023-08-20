<?php

namespace App\Http\Controllers\Admin\Resources\Expense;

trait Columns
{
    use \App\Http\Controllers\Admin\Resources\GlobalColumns;

    /**
     * Define create / update form fields.
     * 
     * @return void
     */
    protected function setColumns()
    {
        $this->creatorColumn();

        $this->crud->column('total_nominal')
            ->label(__('starmoozie::title.total'));

        $this->crud->column('created_at')
            ->label(__('starmoozie::title.created'))
            ->type('datetime');
    }
}
