<?php

namespace App\Http\Controllers\Admin\Resources\Seller;

trait Columns
{
    /**
     * Define create / update form fields.
     * 
     * @return void
     */
    protected function setColumns()
    {
        $this->crud->column('name')
            ->label(__('starmoozie::base.name'));
    }
}
