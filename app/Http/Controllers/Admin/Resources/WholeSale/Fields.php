<?php

namespace App\Http\Controllers\Admin\Resources\WholeSale;

trait Fields
{
    /**
     * Define create / update form fields.
     * 
     * @return void
     */
    protected function setFields()
    {
        $this->crud->field('details')
            ->label(__('starmoozie::title.details'))
            ->type('repeatable')
            ->init_rows(1)
            ->min_rows(1)
            ->subfields($this->detailSubfields());
    }

    protected function detailSubfields()
    {
        return [
            [
                'name'       => 'product_id',
                'type'       => 'relationship',
                'multiple'   => false,
                'model'      => 'App\Models\Product',
                'entity'     => 'products',
                'label'      => __('starmoozie::title.product'),
                'wrapper'    => ['class' => 'form-group col-md-4'],
                'attributes' => ['required' => 'required']
            ],
            [
                'name'       => 'qty',
                'label'      => __('starmoozie::title.qty'),
                'wrapper'    => ['class' => 'form-group col-md-4'],
                'attributes' => ['required' => 'required']
            ],
            [
                'name'       => 'nominal',
                'label'      => __('starmoozie::title.nominal'),
                'prefix'     => 'Rp',
                'wrapper'    => ['class' => 'form-group col-md-4'],
                'attributes' => ['required' => 'required']
            ],
            [
                'name'    => 'note',
                'label'   => __('starmoozie::title.note'),
                'type'    => 'textarea'
            ],
        ];
    }
}
