<?php

namespace App\Http\Controllers\Admin\Resources\User;

trait Main
{
    use Fields, Fetch, Columns, Filters;
    use \App\Traits\AddRemoveRequest;
}
