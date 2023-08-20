<?php

namespace App\Http\Controllers\Admin\Api;

use Starmoozie\LaravelMenuPermission\app\Models\User;

class UserApiController extends BaseApiController
{
    protected $model  = User::class;
    protected $column = "name";
}
