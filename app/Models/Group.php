<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Group extends Model
{
    use HasFactory;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('group');
    }

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];

    public function learningPrograms() : BelongsToMany {
        return $this->belongsToMany(LearningProgram::class, 'group_learning_programs');
    }

    public function users() : BelongsToMany {
        return $this->belongsToMany(User::class, 'group_users')->withPivot('id');
    }
}
