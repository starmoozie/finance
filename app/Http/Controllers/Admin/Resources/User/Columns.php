<?php

namespace App\Http\Controllers\Admin\Resources\User;

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

        $this->crud->column('role')
        ->label(__('starmoozie::menu_permission.role'));
    }
}
