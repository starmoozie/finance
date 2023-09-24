<?php

namespace App\Http\Controllers\Admin\Resources\ProductSale;

trait Columns
{
    /**
     * Define create / update form fields.
     * 
     * @return void
     */
    protected function setColumns()
    {
        $this->crud->column('transaction')
            ->label(__('starmoozie::title.transaction'))
            ->attribute('id')
            ->wrapper([
                'href' => fn($crud, $column, $entry, $related_key) => starmoozie_url("sale/{$related_key}/show")
            ]);

        $this->crud->column('current_qty')
            ->label(__('starmoozie::title.qty'));

        $this->crud->column('current_buy_price')
            ->label(__('starmoozie::title.buy_price'));

        $this->crud->column('current_sell_price')
            ->label(__('starmoozie::title.sell_price'));

        $this->crud->column('current_total_price')
            ->label(__('starmoozie::title.total_price'));

        $this->crud->column('current_stock')
            ->label(__('starmoozie::title.stock'))
            ->escaped(false);

        $this->crud->column('created_at')
            ->label(__('starmoozie::title.created'))
            ->type('datetime');
    }
}
