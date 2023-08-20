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
            'name'        => 'income',
            'route'       => 'income',
            'permissions' => ['create', 'read', 'update', 'delete', 'show', 'personal'],
            'controller'  => 'IncomeCrudController'
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
