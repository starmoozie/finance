<?php

namespace App\Http\Controllers\Admin\Resources\Expense;

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

        $this->dateRangeFilter('created_at', 'selectByCreatedRange');
    }
}
