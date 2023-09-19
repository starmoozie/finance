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
        'name',
        'created_by',
        'stock',
        'price',
        'details'
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

    public function transactions()
    {
        return $this->hasManyJson(
            Transaction::class,
            'details[]->product_id',
            'id'
        );
    }

    public function purchases()
    {
        return $this->transactions()->purchase();
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
        return $query->select(['id', 'name', 'created_by', 'stock', 'price']);
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

    function getCurrentPriceAttribute()
    {
        return rupiah($this->price);
    }

    function getCurrentStockAttribute()
    {
        return rupiah($this->stock);
    }

    public function getOldPriceAttribute()
    {
        $details = $this->details;

        return $details ? end($details)['old_price'] : $this->price;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
