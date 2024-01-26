<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Theme extends Model
{
    use HasFactory;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('theme');
    }

    protected $fillable = ['name'];


    public function learningPrograms() : BelongsToMany {
        return $this->belongsToMany(LearningProgram::class, 'learning_program_themes')->orderByPivot('order', 'asc');;
    }

    public function activities() : BelongsToMany {
        return $this->belongsToMany(Activity::class, 'activity_themes')->orderByPivot('order', 'asc');
    }


}
