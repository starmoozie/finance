<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction as Model;
use App\Models\Product;
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
        // Mapping qty dan harga product
        foreach($merge_details as $detail) {
            $is_has_old_data = array_filter($old_details, fn($q) => $q['product_id'] === $detail['product_id']);
            $operator        = count($is_has_old_data) ? "-" : "+";
            $isset_qty       = isset($final_array[$detail['product_id']]['qty']);

            $final_array[$detail['product_id']]['product_id']  = $detail['product_id'];
            $final_array[$detail['product_id']]['qty']         = $isset_qty
                ? "{$final_array[$detail['product_id']]['qty']} + {$detail['qty']}"
                : "{$operator} {$detail['qty']}";

            $request_qty   = $detail['qty'];
            $calculate_qty = $final_array[$detail['product_id']]['qty'];
            // Apakah item dihapus?jika request qty di kalkulasi dengan qty yang baru === 0, berarti item dihapus
            $final_array[$detail['product_id']]['removed']     = !eval("return {$request_qty} {$calculate_qty};");
            $final_array[$detail['product_id']]['nominal']     = $detail['nominal'];
            $final_array[$detail['product_id']]['request_qty'] = $detail['qty'];
        }

        $this->handleProductPriceAndQty(array_values($final_array));
    }

    /**
     * Handle perhitungan qty dan harga product
     */
    protected function handleProductPriceAndQty($details): void
    {
        foreach ($details as $detail) {
            $product = Product::find($detail['product_id']);

            // Jika actionnya update
            if ($this->crud->actionIs('update')) {
                // Jika item dihapus, maka ambil harga lama, else hitung harga total / qty yang ada di request
                $detail['new_price'] = $detail['removed'] ? $product->old_price : $detail['nominal'] / $detail['request_qty'];
            } else {
                // Perhitungan normal
                $detail['new_price'] = $detail['nominal'] / $detail['qty'];
            }

            $new_details = [...$detail, ...[
                'old_price' => (int) $product->price ?? $detail['new_price'] // Jika harga lama === false, maka ambil harga baru
            ]];

            $product?->update([
                'stock'   => (int) eval("return {$product->stock} + {$detail['qty']};"), // hitung sesuai rumus string
                'price'   => (int) $detail['new_price'],
                'details' => $product->details ? [...$product->details, ...[$new_details]] : [...[$new_details]]
            ]);
        }
    }
}
