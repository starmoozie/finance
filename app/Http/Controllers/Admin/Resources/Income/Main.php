<?php

namespace App\Http\Controllers\Admin\Resources\Income;

trait Main
{
    use Fields, Fetch, Columns, Filters, Shows;
    use \App\Traits\AddRemoveRequest;
}
