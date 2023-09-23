<?php

namespace App\Http\Controllers\Admin\Api;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\ProductTransaction;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Constants\TransactionConstant;

class ProductApiController extends BaseApiController
{
    protected $model              = Product::class;
    protected $searchable_columns = [
        "name",
        "code"
    ];

    function fetchAll(Request $request)
    {
        return !config('starmoozie.crud.sale_config')
            ? $this->saleLatestPurchase($request)
            : $this->saleEachPurchase($request); 
    }

    private function saleLatestPurchase($request)
    {
        return $this->search((new $this->model), $request)
            ->hasStock()
            ->paginate(10);        
    }

    private function saleEachPurchase($request)
    {
        $model = $this->search(
                ProductTransaction::leftJoin('products as p', 'p.id', 'product_transactions.product_id')
                ->leftJoin('transactions as t', 't.id', 'product_transactions.transaction_id'),
                $request
            )
            ->select([
                'p.name',
                'p.code',
                'p.id as id',
                'product_transactions.qty',
                'product_transactions.buy_price',
                'product_transactions.sell_price',
                'product_transactions.id as parent_id',
                \DB::raw("CONCAT(code, ' | ', name) AS code_name")
            ])
            ->where('t.type', TransactionConstant::PURCHASE)
            ->get()
            ->map(function($item) {
                $transaction = ProductTransaction::whereParentId($item->parent_id)->sum('qty');
                $item->stock = $item->qty - $transaction;

                return $item;
            })
            ->filter(fn($item) => $item->stock);

        return $this->paginate($model);
    }

    private function search($query, $request)
    {
        return $query->when($request->q, function($query) use($request) {
            foreach ($this->searchable_columns as $key => $column) {
                $fn = !$key ? 'where' : 'orWhere';
                $query->{$fn}($column, "LIKE", "%{$request->q}%");
            }

            return $query;
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page  = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
