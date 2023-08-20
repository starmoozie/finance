<?php

namespace App\Http\Controllers\Admin\Resources\Sale;

trait Main
{
    use Fields, Fetch, Columns, Filters, Shows;
    use \App\Traits\AddRemoveRequest;
}
