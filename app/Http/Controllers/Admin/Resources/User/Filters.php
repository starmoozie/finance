<?php

namespace App\Http\Controllers\Admin\Resources\User;

trait Filters
{
    /**
     * Define create / update form fields.
     * 
     * @return void
     */
    protected function setFilters()
    {
        $this->crud->filter('role')
        ->label(__('starmoozie::menu_permission.role'))
        ->type('select2_ajax')
        ->values(starmoozie_url('filter/role'))
        ->minimum_input_length(0)
        ->whenActive(fn($value) => $this->crud->addClause('selectByRole', $value))
        ->apply();
    }
}
