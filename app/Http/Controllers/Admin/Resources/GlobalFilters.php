<?php

namespace App\Http\Controllers\Admin\Resources;

trait GlobalFilters
{
    protected function dateRangeFilter($column, $scope)
    {
        $this->crud->filter($column)
            ->label(__('starmoozie::title.created'))
            ->type('date_range')
            ->whenActive(fn($q) => $this->crud->addClause($scope, json_decode($q)));
    }

    protected function creatorFilter()
    {
        if (!$this->crud->hasAccess('personal')) {
            $this->crud->filter('created_by')
                ->label(__('starmoozie::title.creator'))
                ->type('select2_ajax')
                ->values(starmoozie_url('filter/user'))
                ->minimum_input_length(0)
                ->whenActive(fn($value) => $this->crud->addClause('selectByCreator', $value))
                ->apply();
        }
    }
}