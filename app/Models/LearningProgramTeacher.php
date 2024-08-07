<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LearningProgramTeacher extends Model
{
    use HasFactory;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('lp_teacher');
    }

    protected $fillable = [
        'user_id',
        'learning_program_id',
    ];


    public function learningProgram() {
        return $this->belongsTo(LearningProgram::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
