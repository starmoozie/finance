<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseApiController extends Controller
{
    public function filter(Request $request)
    {
        return (new $this->model)
            ->when($request->q, fn($q) => $q->where($this->column, "LIKE", "%{$request->q}%"))
            ->pluck($this->column, 'id');
    }
}
