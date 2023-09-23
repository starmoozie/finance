<?php

namespace App\Http\Controllers\Admin\Resources\Product;
use Spatie\Activitylog\Models\Activity;

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

        $this->crud->addButtonFromView('line', 'product_histories', 'product_histories', 'beginning');
        $this->crud->removeButton('delete');
    }
}
