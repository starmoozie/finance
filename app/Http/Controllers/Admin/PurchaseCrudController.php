<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction as Model;
use App\Http\Requests\PurchaseRequest as Request;
use App\Constants\TransactionConstant;

class PurchaseCrudController extends BaseCrudController
{
    use Resources\Purchase\Main;

    protected $model   = Model::class;
    protected $request = Request::class;
    protected $scopes  = [
        'purchase'
    ];

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $request = $this->crud->getRequest();

        $this->addRequest($request, ['created_by' => starmoozie_user()->id, 'type' => TransactionConstant::PURCHASE]);

        $this->handleProductQty($request->details);

        return $this->traitStore();
    }

    public function update()
    {
        $this->handleUpdateQty();

        return $this->traitUpdate();
    }

    protected function handleUpdateQty(): void
    {
        $old_details   = $this->crud->getCurrentEntry()->details;
        $merge_details = [...$old_details, ...$this->crud->getRequest()->details];

        $final_array = [];
        foreach($merge_details as $detail) {
            $is_has_old_data = array_filter($old_details, fn($q) => $q['product_id'] === $detail['product_id']);
            $operator        = count($is_has_old_data) ? "-" : "+";

            $final_array[$detail['product_id']]['product_id'] = $detail['product_id'];
            $final_array[$detail['product_id']]['qty']        = (isset($final_array[$detail['product_id']]['qty']))
                ? "{$final_array[$detail['product_id']]['qty']} + {$detail['qty']}"
                : "{$operator} {$detail['qty']}";
        }

        $this->handleProductQty(array_values($final_array));
    }

    protected function handleProductQty($details): void
    {
        foreach ($details as $detail) {
            $product = \App\Models\Product::find($detail['product_id']);

            $product?->update([
                'stock'   => eval("return {$product->stock} + {$detail['qty']};"),
                'details' => $detail
            ]);
        }
    }
}
