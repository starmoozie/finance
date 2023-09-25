<?php

namespace App\Http\Controllers\Admin\Resources\Seller;

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
                'name'       => 'phone',
                'label'      => __('starmoozie::title.phone'),
                'wrapper'    => ['class' => 'form-group col-md-6']
            ],
            [
                'name'       => 'note',
                'type'       => 'textarea',
                'label'      => __('starmoozie::title.note'),
                'wrapper'    => ['class' => 'form-group col-md-6']
            ],
        ];
    }
}
