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
            ->label(__('starmoozie::base.name'));
    }
}
