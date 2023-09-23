<?php

namespace App\Http\Controllers\Admin\Resources\Product;

trait Columns
{
    use \App\Http\Controllers\Admin\Resources\GlobalColumns;

    /**
     * Define create / update form fields.
     * 
     * @return void
     */
    protected function setColumns()
    {
        $this->creatorColumn();

        $this->crud->column('code')
            ->label(__('starmoozie::title.code'));

        $this->crud->column('name')
            ->label(__('starmoozie::base.name'));

        if (!config('starmoozie.crud.sale_config')) {
            $this->crud->column('current_buy_price')
                ->label(__('starmoozie::title.buy_price'));

            $this->crud->column('current_sell_price')
                ->label(__('starmoozie::title.sell_price'));
        }

        $this->crud->column('current_stock')
            ->label(__('starmoozie::title.stock'))
            ->escaped(false);
    }
}
