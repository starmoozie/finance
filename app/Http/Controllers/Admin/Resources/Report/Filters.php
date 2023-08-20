<?php

namespace App\Http\Controllers\Admin\Resources\Report;

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
        $this->dateRangeFilter('created_at', 'selectByCreatedRange');
    }
}
