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
        ],
        [
            'route'        => 'filter/user', // Name of route menu
            'method'       => 'get', // crud, get, post, put, patch, delete
            'controller'   => 'Api\UserApiController@filter', // Name of controller
            'type'         => 'dashboard_api' // dashboard, api, dahsboard_api, web
        ],
        [
            'route'        => 'fetch/product', // Name of route menu
            'method'       => 'get', // crud, get, post, put, patch, delete
            'controller'   => 'Api\ProductApiController@fetchAll', // Name of controller
            'type'         => 'dashboard_api' // dashboard, api, dahsboard_api, web
        ],
        [
            'route'        => 'product/{product_id}/sale', // Name of route menu
            'method'       => 'crud', // crud, get, post, put, patch, delete
            'controller'   => 'ProductSaleCrudController', // Name of controller
            'type'         => 'dashboard' // dashboard, api, dahsboard_api, web
        ],
        [
            'route'        => 'product/{product_id}/purchase', // Name of route menu
            'method'       => 'crud', // crud, get, post, put, patch, delete
            'controller'   => 'ProductPurchaseCrudController', // Name of controller
            'type'         => 'dashboard' // dashboard, api, dahsboard_api, web
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
