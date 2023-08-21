<?php

namespace App\Http\Controllers\Admin\Resources\Product;

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

        $this->crud->column('name')
            ->label(__('starmoozie::base.name'));

        $this->crud->column('current_price')
            ->label(__('starmoozie::title.price'));

        $this->crud->column('current_stock')
            ->label(__('starmoozie::title.stock'));
    }
}
