<?php

namespace App\Models;

class Product extends BaseModel
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'code',
        'name',
        'created_by',
        'stock',
        'buy_price',
        'sell_price',
        'details'
    ];

    protected $casts    = [
        'details' => 'array'
    ];

    protected $appends  = [
        "code_name"
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

    public function transactions()
    {
        return $this->belongsToMany(
            Transaction::class,
            'product_transactions'
        );
    }

    public function purchases()
    {
        return $this->transactions()
            ->purchase()
            ->withPivot([
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
            ])
            ->withTimestamps();
    }

    public function sales()
    {
        return $this->transactions()->sale();
    }

    public function histories()
    {
        return $this->hasMany(
            \Spatie\Activitylog\Models\Activity::class,
            'subject_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Default selected columns in list
     */
    public function scopeDefaultSelectColumnsList($query)
    {
        return $query->select(['id', 'name', 'created_by', 'stock', 'sell_price', 'buy_price', 'code']);
    }

    /**
     * Select data has stock
     */
    public function scopeHasStock($query)
    {
        return $query->where('stock', '>', 0);
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

    function getCurrentSellPriceAttribute()
    {
        return rupiah($this->sell_price);
    }

    function getCurrentStockAttribute()
    {
        $stock = rupiah($this->stock);
        $class = $this->stock <= config('starmoozie.crud.min_stock') ? 'text-danger' : '';

        return "<span class='{$class}'>{$stock}</span>";
    }

    public function getOldPriceAttribute()
    {
        $details = $this->details;

        return $details ? end($details)['old_price'] : $this->sell_price;
    }

    public function getCodeNameAttribute()
    {
        return "{$this->code} | {$this->name}";
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
