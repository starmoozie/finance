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
