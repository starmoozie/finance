<?php

namespace App\Models;

use Carbon\Carbon;

class Transaction extends BaseModel
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'created_by',
        'details',
        'is_income',
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

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeIncome($query)
    {
        return $query->where('is_income', true);
    }

    public function scopeExpense($query)
    {
        return $query->where('is_income', false);
    }

    public function scopeSplitDebitCredit($query)
    {
        return $query->selectRaw("(CASE WHEN is_income = 1 THEN created_at ELSE NULL END) as aa");
    }

    function scopeSelectByCreatedRange($query, $dates)
    {
        return $query->whereDate('created_at', '>=', dateFormat($dates->from))
            ->whereDate('created_at', '<=', dateFormat($dates->to));
    }

    function scopeSelectByCreator($query, $user_id)
    {
        return $query->whereCreatedBy($user_id);
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

    public function getDebitAttribute()
    {
        return $this->is_income ? $this->total_nominal : 0;
    }

    public function getCreditAttribute()
    {
        return !$this->is_income ? $this->total_nominal : 0;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
