<?php

namespace App\Http\Controllers\Admin\Resources\Product;

trait Filters
{
    use \App\Http\Controllers\Admin\Resources\GlobalFilters;

    /**
     * Define filter fields.
     * 
     * @return void
     */
    protected function setFilters()
    {
        $this->creatorFilter();

        $this->crud->filter('low_stock')
            ->label(__('starmoozie::title.low_stock'))
            ->type('simple')
            ->whenActive(fn($q) => $this->crud->addClause('selectLowStock'))
            ->apply();
    }
}
