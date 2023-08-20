<?php

namespace App\Http\Controllers\Admin\Resources\User;

trait Fields
{
    /**
     * Define create / update form fields.
     * 
     * @return void
     */
    protected function setFields()
    {
        $this->crud->field('name')
        ->label(__('starmoozie::base.name'))
        ->size(4)
        ->tab(__('starmoozie::title.general'));

        $this->crud->field('mobile')
        ->size(4)
        ->label(__('starmoozie::menu_permission.mobile'))
        ->tab(__('starmoozie::title.general'));

        $this->crud->field('role')
        ->size(4)
        ->allows_null(false)
        ->label(__('starmoozie::menu_permission.role'))
        ->options(fn($q) => $q->when(!is_me(starmoozie_user()->email), fn($q) => $q->where('name', '!=', 'developer')))
        ->tab(__('starmoozie::title.general'));

        $this->crud->field('email')
        ->size(4)
        ->label(__('starmoozie::menu_permission.email'))
        ->tab(__('starmoozie::title.login_information'));

        $this->crud->field('password')
        ->type('password')
        ->size(4)
        ->label(__('starmoozie::menu_permission.password'))
        ->tab(__('starmoozie::title.login_information'));

        $this->crud->field('password_confirmation')
        ->type('password')
        ->size(4)
        ->label(__('starmoozie::menu_permission.password_confirm'))
        ->tab(__('starmoozie::title.login_information'));
    }
}
