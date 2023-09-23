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
        $this->crud->field('code')
            ->label(__('starmoozie::title.code'))
            ->size(6)
            ->hint(__('starmoozie::title.hint_code'));

        $this->crud->field('name')
            ->label(__('starmoozie::base.name'))
            ->size(6);
    }
}
