<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Constants\LengthContant;

class CheckAmountProfitRule implements Rule
{
    protected $details;
    protected $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $split_attribute     = explode('.', $attribute);
        $current_index       = $split_attribute[1];
        $current_type_profit = $this->details[$current_index]['type_profit'];

        if ($current_type_profit) {
            $this->message = LengthContant::MAX_NUMERIC;

            return strlen($value) <= LengthContant::MAX_NUMERIC;
        }

        $this->message = LengthContant::MAX_PERCENT;

        // Percent
        return $value <= LengthContant::MAX_PERCENT;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.max.numeric', [
            'attribute' => __('starmoozie::title.amount_profit'),
            'max'       => $this->message
        ]);
    }
}
