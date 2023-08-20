<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Starmoozie\LaravelMenuPermission\app\Models\Route;

class RouteSeeder extends Seeder
{
    protected $data = [
        [
            'route'        => 'filter/role', // Name of route menu
            'method'       => 'get', // crud, get, post, put, patch, delete
            'controller'   => 'Api\RoleApiController@filter', // Name of controller
            'type'         => 'dashboard_api' // dashboard, api, dahsboard_api, web
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data as $route) {
            Route::updateOrCreate($route, $route);
        }
    }
}
