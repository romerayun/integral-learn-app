<?php

namespace App\Models;


use Spatie\Permission\Models\Permission as SpatiePermission;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Permission extends SpatiePermission
{
    use LogsActivity;

//    protected static $logName = 'permissions';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('permission');
    }
}
