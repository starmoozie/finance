<?php

namespace App\Http\Controllers\Admin\Resources\Report;

trait Columns
{
    /**
     * Define create / update form fields.
     * 
     * @return void
     */
    protected function setColumns()
    {
        $this->crud->column('created_at')
            ->label(__('starmoozie::title.created'))
            ->type('datetime');

        $this->crud->column('expense')
            ->label(__('starmoozie::title.expense'))
            ->wrapper([
                'element' => 'div',
                'class'   => 'text-right'
            ])
            ->position('right');

        $this->crud->column('purchase')
            ->label(__('starmoozie::title.purchase'))
            ->wrapper([
                'element' => 'div',
                'class'   => 'text-right'
            ])
            ->position('right');

        $this->crud->column('sale')
            ->label(__('starmoozie::title.sale'))
            ->wrapper([
                'element' => 'div',
                'class'   => 'text-right'
            ])
            ->position('right');

        $this->crud->column('balance')
            ->label(__('starmoozie::title.balance'))
            ->wrapper([
                'element' => 'div',
                'class'   => 'text-right'
            ])
            ->position('right');
    }
}
