<?php

namespace App\Http\Controllers\Admin\Resources\Product;

use App\Models\ProductCategory;

trait Fetch
{
    use \Starmoozie\CRUD\app\Http\Controllers\Operations\FetchOperation;

    protected function fetchProductCategory()
    {
        return $this->fetch(ProductCategory::class);
    }
}
