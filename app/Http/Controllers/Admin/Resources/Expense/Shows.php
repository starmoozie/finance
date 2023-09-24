<?php

namespace App\Http\Controllers\Admin\Resources\Expense;

trait Shows
{
    /**
     * Define create / update form fields.
     * 
     * @return void
     */
    protected function setShows()
    {
        $this->setColumns();

        $this->crud->column('details')
            ->type('table')
            ->columns([
                'total_price' => __('starmoozie::title.total_price'),
                'note'        => __('starmoozie::title.note')
            ])
            ->after('total_nominal');
    }
}
