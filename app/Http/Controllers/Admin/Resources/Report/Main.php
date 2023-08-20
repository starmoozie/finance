<?php

namespace App\Http\Controllers\Admin\Resources\Report;

trait Main
{
    use Fields, Fetch, Columns, Filters;
    use \App\Traits\AddRemoveRequest;
}
