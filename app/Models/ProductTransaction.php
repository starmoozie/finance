<?php

namespace App\Models;

class ProductTransaction extends BaseModel
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'product_id',
        'transaction_id',
        'qty',
        'buy_price',
        'sell_price',
        'total_price',
        'amount_profit',
        'type_profit',
        'calculated_profit',
        'note',
        'parent_id',
        'stock'
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeSale($query)
    {
        return $query->whereHas('transaction', fn($q) => $q->sale());
    }

    public function scopePurchase($query)
    {
        return $query->whereHas('transaction', fn($q) => $q->purchase());
    }

    public function scopeSelectByProduct($query, $product_id)
    {
        return $query->whereProductId($product_id);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    function getCurrentBuyPriceAttribute()
    {
        return rupiah($this->buy_price);
    }

    function getCurrentQtyAttribute()
    {
        return rupiah($this->qty);
    }

    function getCurrentSellPriceAttribute()
    {
        return rupiah($this->sell_price);
    }

    function getCurrentStockAttribute()
    {
        return rupiah($this->stock);
    }

    function getCurrentTotalPriceAttribute()
    {
        return rupiah($this->total_price);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
