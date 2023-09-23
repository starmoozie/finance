<?php

namespace App\Traits;

/**
 * 
 */
trait GenerateId
{
    protected $unique_code = 'code';

    /**
      * Boot function from Laravel.
    **/
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()}   = \Str::uuid()->toString();
            }

            if (in_array($model->unique_code, $model->fillable) && (empty($model->{$model->unique_code}) || !$model->{$model->unique_code})) {
                $model->{$model->unique_code} = $model->generateUniqueCode($model);
            }
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
    **/
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
    *
    * @return string
    **/
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * Generate unique code
     */
    private function generateUniqueCode($model): string
    {
        $value     = $model->max($model->unique_code);
        $date      = date('ymd');
        $numbering = $value ? explode('-', $value)[1] : 0;
        $increment = $numbering + 1;

        return "{$date}-{$increment}";
    }
}
