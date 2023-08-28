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

        $this->addRequest($request, [
            ...['created_by' => starmoozie_user()->id, 'type' => TransactionConstant::PURCHASE],
            ...$this->handleDetails($request->details)
        ]);

        $response = $this->traitStore();

        $this->handleProductPriceAndQty($request->details);

        return $response;
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $old_entry = $this->crud->getCurrentEntry();
        $request   = $this->crud->getRequest();

        $this->addRequest($request, $this->handleDetails($request->details));

        $response = $this->traitUpdate();
        
        $final_array = $this->handleAddOrRemoveDetails($old_entry->details);

        $this->handleProductPriceAndQty($final_array);

        return $response;
    }

    /**
     * Map and replace request details
     */
    protected function handleDetails(array $details): array
    {
        $data        = [];
        $total_price = 0;
        $total_qty   = 0;

        foreach ($details as $detail) {
            $detail['product_id'] = explode('~', $detail['product_id'])[0];
            $detail['qty']        = rupiahToInteger($detail['qty']);
            $detail['sub_total']  = rupiahToInteger($detail['sub_total']);

            $total_price += $detail['sub_total'];
            $total_qty   += $detail['qty'];

            $data[] = $detail;
        }

        return [
            'total_qty'   => $total_qty,
            'total_price' => $total_price,
            'details'     => $data
        ];
    }

    /**
     * Logic handling add or remove item in request details
     */
    protected function handleAddOrRemoveDetails(array $old_details): array
    {
        $final_array = [];
        foreach ([...$old_details, ...$this->crud->entry->details] as $detail) {
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
            $final_array[$detail['product_id']]['sub_total']   = $detail['sub_total'];
            $final_array[$detail['product_id']]['request_qty'] = rupiahToInteger($detail['qty']);
        }

        return $final_array;
    }

    /**
     * Handling product qty and price
     */
    protected function handleProductPriceAndQty($details)
    {
        foreach ($details as $detail) {
            $product = Product::find($detail['product_id']);

            // Jika actionnya update
            if ($this->crud->actionIs('update')) {
                // Jika item dihapus, maka ambil harga lama, else hitung harga total / qty yang ada di request
                $detail['new_price'] = $detail['removed'] ? $product->old_price : $detail['sub_total'] / $detail['request_qty'];
            } else {
                // Perhitungan normal
                $detail['new_price'] = $detail['sub_total'] / $detail['qty'];
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
