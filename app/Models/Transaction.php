<?php

namespace App\Models;

use Carbon\Carbon;
use App\Constants\TransactionConstant;

class Transaction extends BaseModel
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'created_by',
        'details',
        'type',
        'total_price',
        'total_qty'
    ];
    protected $casts    = [
        'details' => 'array'
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function products()
    {
        return $this->belongsToJson(
            Product::class,
            'details[]->product_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeSale($query)
    {
        return $query->where('type', TransactionConstant::SALE);
    }

    public function scopeExpense($query)
    {
        return $query->where('type', TransactionConstant::EXPENSE);
    }

    public function scopePurchase($query)
    {
        return $query->where('type', TransactionConstant::PURCHASE);
    }

    public function scopeSplitDebitCredit($query)
    {
        return $query->selectRaw("(CASE WHEN type = 1 THEN created_at ELSE NULL END) as aa");
    }

    function scopeSelectByCreatedRange($query, $dates)
    {
        return $query->whereDate('created_at', '>=', dateFormat($dates->from))
            ->whereDate('created_at', '<=', dateFormat($dates->to));
    }

    function scopeSelectByNominalRange($query, $nominal_range)
    {
        return $query
            ->get()
            ->filter(function($query) use ($nominal_range) {
                $total_nominal = (int) str_replace('.', '', $query->total_nominal);

                return $total_nominal >= (int) $nominal_range->from && $total_nominal <= (int) $nominal_range->to;
            });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Sum nominal as total_nominal
     */
    public function getTotalNominalAttribute(): string
    {
        return rupiah(array_sum(array_column($this->details, 'nominal')));
    }

    /**
     * Sum qty as total_qty
     */
    public function getTotalQtyAttribute(): string
    {
        return rupiah(array_sum(array_column($this->details, 'qty')));
    }

    public function getDebitAttribute()
    {
        return $this->type === 1 ? $this->total_nominal : 0;
    }

    public function getCreditAttribute()
    {
        return $this->type !== TransactionConstant::SALE ? $this->total_nominal : 0;
    }

    public function getDetailsWithProductAttribute()
    {
        $products = $this->products;
        $details  = [];
        foreach ($this->details as $key => $detail) {
            $details[$key] = $detail;
            $details[$key]['product'] = $products->where('id', $detail['product_id'])->first()?->name;
            unset($details[$key]['product_id']);
        }

        return $details;
    }

    public function getTotalPriceFormattedAttribute()
    {
        return rupiah($this->total_price);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
