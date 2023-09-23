<?php

namespace App\Http\Controllers\Admin;

use App\Models\{
    Transaction as Model,
    Product
};
use App\Http\Requests\SaleRequest as Request;
use App\Constants\TransactionConstant;

class SaleCrudController extends BaseCrudController
{
    use Resources\Sale\Main;

    protected $model   = Model::class;
    protected $request = Request::class;
    protected $scopes  = [
        'sale',
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

        $this->addRequest($request, [
            ...['created_by' => starmoozie_user()->id, 'type' => TransactionConstant::SALE],
            ...$this->handleDetails($request->details)
        ]);

        $response = $this->traitStore();

        $this->handleProductQty($request->details);

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

        $this->handleProductQty($final_array);

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
            $detail['stock']      = rupiahToInteger($detail['stock']);
            $detail['sell_price']      = rupiahToInteger($detail['sell_price']);
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
                ? "{$final_array[$detail['product_id']]['qty']} - {$detail['qty']}"
                : "{$operator} {$detail['qty']}";
        }

        return $final_array;
    }

    /**
     * Handling product qty
     */
    protected function handleProductQty(array $details): void
    {
        foreach ($details as $detail) {
            $product = Product::find($detail['product_id']);

            $product->update(['stock' => (int) eval("return {$product->stock} - {$detail['qty']};")]);
        }
    }
}
