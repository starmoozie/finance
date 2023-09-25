<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Starmoozie\LaravelMenuPermission\app\Models\Menu;
use Starmoozie\LaravelMenuPermission\app\Models\Permission;

class MenuSeeder extends Seeder
{
    protected $data = [
        [
            'name'        => 'menu permission',
            'route'       => '#',
            'permissions' => ['read'],
            'controller'  => null
        ],
        [
            'name'        => 'user management',
            'route'       => '#',
            'permissions' => ['read'],
            'controller'  => null
        ],
        [
            'name'        => 'transaction',
            'route'       => '#',
            'permissions' => ['read'],
            'controller'  => null
        ],
        [
            'name'        => 'sale',
            'route'       => 'sale',
            'permissions' => ['create', 'read', 'update', 'delete', 'show', 'personal'],
            'controller'  => 'SaleCrudController'
        ],
        [
            'name'        => 'expense',
            'route'       => 'expense',
            'permissions' => ['create', 'read', 'update', 'delete', 'show', 'personal'],
            'controller'  => 'ExpenseCrudController'
        ],
        [
            'name'        => 'report',
            'route'       => 'report',
            'permissions' => ['read', 'export', 'personal'],
            'controller'  => 'ReportCrudController'
        ],
        [
            'name'        => 'master',
            'route'       => '#',
            'permissions' => ['read'],
            'controller'  => null
        ],
        [
            'name'        => 'product',
            'route'       => 'product',
            'permissions' => ['create', 'read', 'update', 'delete', 'show', 'personal'],
            'controller'  => 'ProductCrudController'
        ],
        [
            'name'        => 'purchase',
            'route'       => 'purchase',
            'permissions' => ['create', 'read', 'update', 'delete', 'show', 'personal'],
            'controller'  => 'PurchaseCrudController'
        ],
        [
            'name'        => 'product category',
            'route'       => 'product-category',
            'permissions' => ['create', 'read', 'update', 'delete', 'show', 'personal'],
            'controller'  => 'ProductCategoryCrudController'
        ],
        [
            'name'        => 'seller',
            'route'       => 'seller',
            'permissions' => ['create', 'read', 'update', 'delete', 'show', 'personal'],
            'controller'  => 'SellerCrudController'
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data as $value) {
            $data = \Arr::only($value, ['name', 'route', 'controller']);
            $menu = Menu::updateOrCreate($data, $data);

            // Insert permissions
            $permissions = Permission::whereIn('name', $value['permissions'])->pluck('id')->toArray();
            $menu->permission()->sync($permissions);
        }
    }
}
