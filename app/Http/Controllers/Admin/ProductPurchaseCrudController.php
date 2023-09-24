<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductTransaction as Model;
use App\Http\Requests\ProductPurchaseRequest as Request;

class ProductPurchaseCrudController extends BaseCrudController
{
    use Resources\ProductPurchase\Main;

    protected $model   = Model::class;
    protected $request = Request::class;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        $path       = request()->segment(2);
        $sub_path   = request()->segment(4);
        $heading    = str_replace('-', ' ', $sub_path);
        $label      = __("starmoozie::title.$heading");
        $product_id = \Route::current()->parameter('product_id');

        $product = Product::find($product_id);

        if (!$product) {
            abort(404);
        }

        $this->crud->setModel($this->model);
        $this->crud->setRoute(config('starmoozie.base.route_prefix') . "/{$path}/{$product_id}/purchase");
        $this->crud->setEntityNameStrings($label, $label);
        $this->crud->setSubheading(__('starmoozie::title.from_product', [
            'attribute' => $product->code,
            'url' => url(config('starmoozie.base.route_prefix') . "/{$path}/{$product_id}/show")
        ]), 'index');

        $this->crud->addClause('selectByProduct', $product_id);
        $this->crud->addClause('purchase');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @return void
     */
    protected function setupListOperation()
    {
        parent::setupListOperation();

        $this->crud->setOperationSetting('searchableTable', false);

        $this->crud->removeAllButtons();
        $this->crud->denyAccess(['edit', 'create', 'delete']);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @return void
     */
    protected function setupCreateOperation()
    {
        parent::setupCreateOperation();

        $this->crud->denyAccess(['edit', 'create', 'delete']);
    }
}
