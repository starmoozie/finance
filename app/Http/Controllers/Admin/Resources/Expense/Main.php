<?php

namespace App\Http\Controllers\Admin\Resources\Expense;

trait Main
{
    use Fields, Fetch, Columns, Filters, Shows;
    use \App\Traits\AddRemoveRequest;
}
