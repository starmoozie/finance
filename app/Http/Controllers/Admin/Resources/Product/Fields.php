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
            ->size(4)
            ->hint(__('starmoozie::title.hint_code'));

        $this->crud->field('productCategory')
            ->label(__('starmoozie::title.productcategory'))
            ->size(4)
            ->ajax(true)
            ->inline_create(true)
            ->minimum_input_length(0);

        $this->crud->field('name')
            ->label(__('starmoozie::base.name'))
            ->size(4);
    }
}
