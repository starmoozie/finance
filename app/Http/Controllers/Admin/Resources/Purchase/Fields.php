<?php

namespace App\Http\Controllers\Admin\Resources\Purchase;

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
                'attributes' => ['required' => 'required'],
                'ajax'       => true,
                'inline_create' => ['entity' => 'product'],
                'minimum_input_length' => 0,
                'attribute'  => 'code_name',
                'placeholder' => __('starmoozie::title.select_product')
            ],
            [
                'name'       => 'qty',
                'label'      => __('starmoozie::title.qty'),
                'wrapper'    => ['class' => 'form-group col-md-4'],
                'attributes' => ['required' => 'required']
            ],
            [
                'name'       => 'sub_total',
                'label'      => __('starmoozie::title.total_price'),
                'prefix'     => 'Rp',
                'wrapper'    => ['class' => 'form-group col-md-4'],
                'attributes' => ['required' => 'required']
            ],
            [
                'name'    => 'type_profit',
                'label'   => __('starmoozie::title.type_profit'),
                'type'    => 'radio',
                'options' => [
                    0 => __('starmoozie::title.percent'),
                    1 => __('starmoozie::title.money')
                ],
                'wrapper' => ['class' => 'form-group col-md-4'],
                'default' => 1,
                'inline'  => true
            ],
            [
                'name'       => 'profit',
                'label'      => __('starmoozie::title.profit'),
                'type'       => 'number',
                'wrapper'    => ['class' => 'form-group col-md-4'],
                'attributes' => ['required' => 'required', 'step' => '.01']
            ],
            [
                'name'    => 'note',
                'label'   => __('starmoozie::title.note'),
                'type'    => 'textarea'
            ],
        ];
    }
}
