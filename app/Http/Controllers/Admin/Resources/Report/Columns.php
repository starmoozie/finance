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

        $this->crud->column('debit')
            ->label(__('starmoozie::title.debit'))
            ->wrapper([
                'element' => 'div',
                'class'   => 'text-right'
            ])
            ->position('right');

        $this->crud->column('credit')
            ->label(__('starmoozie::title.credit'))
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
