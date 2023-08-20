<?php

namespace App\Http\Controllers\Admin\Resources\Product;

trait Fields
{
    /**
     * Define create / update form fields.
     * 
     * @return void
     */
    protected function setFields()
    {
        $this->crud->field('name')
            ->label(__('starmoozie::base.name'))
            ->size(6);

        $this->crud->field('stock')
            ->label(__('starmoozie::title.stock'))
            ->size(6);
    }
}
