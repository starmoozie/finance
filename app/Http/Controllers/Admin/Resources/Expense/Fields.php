<?php

namespace App\Http\Controllers\Admin\Resources\Expense;

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
                'name'       => 'nominal',
                'label'      => __('starmoozie::title.nominal'),
                'prefix'     => 'Rp',
                'wrapper'    => ['class' => 'form-group col-md-4'],
                'attributes' => ['required' => 'required']
            ],
            [
                'name'    => 'note',
                'label'   => __('starmoozie::title.note'),
                'type'    => 'textarea',
                'wrapper' => ['class' => 'form-group col-md-8']
            ],
        ];
    }
}
