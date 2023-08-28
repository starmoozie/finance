<?php

namespace App\Http\Controllers\Admin\Resources\Sale;

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
                'type'       => 'select2_from_ajax_sale_product',
                'multiple'   => false,
                'model'      => 'App\Models\Product',
                'entity'     => 'products',
                'label'      => __('starmoozie::title.product'),
                'wrapper'    => ['class' => 'form-group col-md-4'],
                'attributes' => ['required' => 'required'],
                'data_source'=> starmoozie_url('fetch/product'),
                'allows_null'=> false,
                'minimum_input_length' => 0
            ],
            [
                'name'       => 'price',
                'label'      => __('starmoozie::title.price'),
                'prefix'     => 'Rp',
                'wrapper'    => ['class' => 'form-group col-md-3'],
                'attributes' => ['required' => 'required', 'readonly' => 'readonly']
            ],
            [
                'name'       => 'stock',
                'label'      => __('starmoozie::title.stock'),
                'wrapper'    => ['class' => 'form-group col-md-1'],
                'attributes' => ['required' => 'required', 'readonly' => 'readonly']
            ],
            [
                'name'       => 'qty',
                'label'      => __('starmoozie::title.qty'),
                'type'       => 'text_sale_qty',
                'wrapper'    => ['class' => 'form-group col-md-1'],
                'attributes' => ['required' => 'required']
            ],
            [
                'name'       => 'sub_total',
                'label'      => __('starmoozie::title.sub_total'),
                'prefix'     => 'Rp',
                'wrapper'    => ['class' => 'form-group col-md-3'],
                'attributes' => ['required' => 'required', 'readonly' => 'readonly']
            ],
        ];
    }
}
