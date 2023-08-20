<?php

namespace App\Http\Controllers\Admin\Resources\Income;

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

        // $this->crud->filter('number')
        //     ->type('range')
        //     ->whenActive(fn($value) => $this->crud->addClause('selectByNominalRange', json_decode($value)));

        $this->dateRangeFilter('created_at', 'selectByCreatedRange');
    }
}
