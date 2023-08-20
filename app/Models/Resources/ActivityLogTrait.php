<?php

namespace App\Models\Resources;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

/**
 * 
 */
trait ActivitylogTrait
{
    use \Spatie\Activitylog\Traits\LogsActivity;

    protected static $recordEvents = ['deleted', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(array_diff($this->fillable, ['user_id']))
            ->useLogName($this->getTable());
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->causer_id = starmoozie_user()?->id;
    }
}