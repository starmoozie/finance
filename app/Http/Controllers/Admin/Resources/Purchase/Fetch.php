<?php

namespace App\Http\Controllers\Admin\Resources\Purchase;

use App\Models\Product;

trait Fetch
{
    use \Starmoozie\CRUD\app\Http\Controllers\Operations\FetchOperation;

    protected function fetchProducts()
    {
        return $this->fetch(Product::class);
    }
}
