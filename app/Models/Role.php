<?php

namespace App\Models;


use Spatie\Permission\Models\Role as SR;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Role extends SR
{
    use LogsActivity;

//    protected static $logName = 'permissions';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('role');
    }
}
