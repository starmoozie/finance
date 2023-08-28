<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckIfQtyNotMoreThanStockRule implements Rule
{
    public $details;

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
        $attributeArray = explode('.', $attribute);

        return rupiahToInteger($value) <= rupiahToInteger($this->details[$attributeArray[1]]['stock']);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.lte.array', ['attribute' => __('starmoozie::title.qty'), 'value' => __('starmoozie::title.stock')]);
    }
}
