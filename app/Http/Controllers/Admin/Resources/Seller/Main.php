<?php

namespace App\Http\Controllers\Admin\Resources\Seller;

trait Main
{
    use Fields, Fetch, Columns, Filters;
    use \Starmoozie\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
}
