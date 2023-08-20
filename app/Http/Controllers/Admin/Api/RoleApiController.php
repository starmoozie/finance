<?php

namespace App\Http\Controllers\Admin\Api;

use Starmoozie\LaravelMenuPermission\app\Models\Role;

class RoleApiController extends BaseApiController
{
    protected $model  = Role::class;
    protected $column = "name";
}
