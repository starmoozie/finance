<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction as Model;
use App\Models\Product;
use App\Http\Requests\PurchaseRequest as Request;
use App\Constants\TransactionConstant;
use Starmoozie\CRUD\app\Library\Widget;

class PurchaseCrudController extends BaseCrudController
{
    use Resources\Purchase\Main;

    protected $model   = Model::class;
    protected $request = Request::class;
    protected $scopes  = [
        'purchase',
        'defaultSelectColumnsList'
    ];
    protected $orders  = [
        ['name' => 'updated_at', 'type' => 'desc']
    ];

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $request = $this->crud->getRequest();

        $this->addRequest($request, [...[
            'created_by' => starmoozie_user()->id,
            'type'       => TransactionConstant::PURCHASE
        ], ...$this->defaultAppendNewRequest($request->details)]);

        $response = $this->traitStore();

        $this->handlePivotRelationship($request->details);

        return $response;
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $request   = $this->crud->getRequest();

        $this->addRequest($request, $this->defaultAppendNewRequest($request->details));

        $response = $this->traitUpdate();

        $this->handlePivotRelationship($request->details);

        return $response;
    }

    /**
     * Default new appended attribute to request
     */
    private function defaultAppendNewRequest($details): array
    {
        return [
            'total_price' => array_sum(array_column($details, 'total_price')),
            'total_qty'   => array_sum(array_column($details, 'qty'))
        ];
    }

    /**
     * Handle pivot 
     */
    private function handlePivotRelationship($details): void
    {
        $relation_values = [];
        foreach ($details as $key => $detail) {
            $buy_price         = $detail['total_price'] / $detail['qty'];
            $calculated_profit = calculateProfit($detail['type_profit'], $detail['amount_profit'], $buy_price);

            $pivot_data                      = $detail;
            $pivot_data['buy_price']         = $buy_price;
            $pivot_data['sell_price']        = $pivot_data['buy_price'] + $calculated_profit;
            $pivot_data['calculated_profit'] = $calculated_profit;

            $relation_values[$detail['product_id']] = $pivot_data;
        }

        $this->addRemoveProductLogic($relation_values, $this->crud->entry->details->toArray());

        $this->crud->entry->products()->sync($relation_values);
    }

    /**
     * Logic to add or remove product
     */
    private function addRemoveProductLogic($new_pivot, $old_pivot): bool
    {
        $unique = [];
        foreach (array_values([...$new_pivot, ...$old_pivot]) as $key => $detail) {
            $operator    = collect($old_pivot)->filter(fn($q) => $q['product_id'] === $detail['product_id'])->count() ? '-' : '+';
            $isset_qty   = isset($unique[$detail['product_id']]['qty']);
            $request_qty = collect($new_pivot)->filter(fn($q) => $q['product_id'] === $detail['product_id'])->first();

            // Merged old + new pivot then unique data by product_id
            $unique[$detail['product_id']] = $detail;

            /**
             * Identity operator to calculate product stock
             * If isset_qty then, - old_qty + new_qty ( Identify if quantity of old product has additions/subtractions? )
             * Else ? this item identity if add or remove product, if product removed then operator is negative else positive
             */
            $unique[$detail['product_id']]['operator'] = $isset_qty
                ? "- {$unique[$detail['product_id']]['qty']} + {$request_qty['qty']}"
                : "{$operator} {$detail['qty']}";
        }

        return $this->updateProduct($unique);
    }

    /**
     * Update product
     * Formula stock product ( old_stock - old_qty_from_pivot + new_request_qty )
     */
    private function updateProduct($unique): bool
    {
        foreach ($unique as $key => $value) {
            $product = Product::find($value['product_id']);

            $product->update([
                'stock'      => eval("return {$product->stock} {$value['operator']};"),
                'buy_price'  => $value['buy_price'],
                'sell_price' => $value['sell_price']
            ]);
        }

        return true;
    }
}
