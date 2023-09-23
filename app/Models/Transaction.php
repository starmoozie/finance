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
    protected $defaultListColumns = [
        'id',
        'created_at',
        'total_price',
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

    // public function products()
    // {
    //     return $this->belongsToJson(
    //         Product::class,
    //         'details[]->product_id',
    //         'id'
    //     );
    // }
    
    public function products()
    {
        return $this->BelongsToMany(Product::class, 'product_transactions')
        ->withPivot([
            'qty',
            'buy_price',
            'sell_price',
            'total_price',
            'amount_profit',
            'type_profit',
            'calculated_profit',
            'note'
        ])
        ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Select only sale type
     */
    public function scopeSale($query)
    {
        return $query->where('type', TransactionConstant::SALE);
    }

    /**
     * Select only expense type
     */
    public function scopeExpense($query)
    {
        return $query->where('type', TransactionConstant::EXPENSE);
    }

    /**
     * Select only purchase type
     */
    public function scopePurchase($query)
    {
        return $query->where('type', TransactionConstant::PURCHASE);
    }

    /**
     * Select only not sale type
     */
    public function scopeNotIncome($query)
    {
        return $query->where('type', '!=', TransactionConstant::SALE);
    }

    /**
     * Select by created_at range
     */
    public function scopeSelectByCreatedRange($query, $dates)
    {
        return $query->whereDate('created_at', '>=', dateFormat($dates->from))
            ->whereDate('created_at', '<=', dateFormat($dates->to));
    }

    /**
     * Select by nominal range
     */
    public function scopeSelectByNominalRange($query, $nominal_range)
    {
        return $query
            ->get()
            ->filter(function($query) use ($nominal_range) {
                $total_nominal = (int) str_replace('.', '', $query->total_nominal);

                return $total_nominal >= (int) $nominal_range->from && $total_nominal <= (int) $nominal_range->to;
            });
    }

    /**
     * Select by created_at less or equal than x
     */
    public function scopeLteCreated($query, $created_at)
    {
        return $query->where('created_at', '<=', $created_at);
    }

    /**
     * Select by current month
     */
    public function scopeSelectCurrentMonth($query)
    {
        return $query->whereMonth('created_at', Carbon::now()->month);
    }

    /**
     * Sum each type
     */
    public function scopeSumEachType($query)
    {
        return $query->groupBy('type')->select([
            'type',
            \DB::raw('SUM(total_price) as total_price'),
        ]);
    }

    /**
     * Count each type
     */
    public function scopeCountEachType($query)
    {
        return $query->groupBy('type')->select([
            'type',
            \DB::raw('COUNT(id) as total'),
        ]);
    }

    /**
     * Default selected columns
     */
    public function scopeDefaultSelectColumns($query)
    {
        return $query->select($this->defaultListColumns);
    }

    /**
     * Default selected columns in list
     */
    public function scopeDefaultSelectColumnsList($query)
    {
        return $query->defaultSelectColumns()->addSelect(['created_by']);
    }

    /**
     * Default selected columns in list
     */
    public function scopeDefaultSelectListColumnsReport($query)
    {
        return $query->defaultSelectColumns()->addSelect(['type']);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Current sale
     */
    public function getSaleAttribute()
    {
        return $this->type === TransactionConstant::SALE ? $this->total_price_formatted : 0;
    }

    /**
     * Current expense
     */
    public function getExpenseAttribute()
    {
        return $this->type === TransactionConstant::EXPENSE ? $this->total_price_formatted : 0;
    }

    /**
     * Current purchase
     */
    public function getPurchaseAttribute()
    {
        return $this->type === TransactionConstant::PURCHASE ? $this->total_price_formatted : 0;
    }

    /**
     * Show details with product name
     */
    public function getDetailsWithProductAttribute()
    {
        $products = $this->products;
        $details  = [];
        foreach ($this->details as $key => $detail) {
            $details[$key] = $detail;
            $details[$key]['product'] = $products->where('id', $detail['product_id'])->first()?->name;

            if (isset($detail['type_profit'])) {
                $details[$key]['type_profit_formatted'] = $detail['type_profit'] ? __('starmoozie::title.money') : __('starmoozie::title.percent');
            }
            unset($details[$key]['product_id']);
        }

        return $details;
    }

    /**
     * Total price formatted
     */
    public function getTotalPriceFormattedAttribute()
    {
        return rupiah($this->total_price);
    }

    /**
     * Total price of debit where created less or equal than current created
     */
    public function getLastTotalDebitAttribute()
    {
        return Self::lteCreated($this->created_at)->sale()->sum('total_price');
    }

    /**
     * Total price of credit where created less or equal than current created
     */
    public function getLastTotalCreditAttribute()
    {
        return Self::lteCreated($this->created_at)->notIncome()->sum('total_price');
    }

    /**
     * Current balance
     */
    public function getBalanceAttribute()
    {
        return rupiah($this->last_total_debit - $this->last_total_credit);
    }

    public function getDetailsAttribute($value)
    {
        return $this->products->pluck('pivot');
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
