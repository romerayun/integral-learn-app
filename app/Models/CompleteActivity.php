<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompleteActivity extends Model
{
    use HasFactory;

    protected $table = 'complete_activities';
    protected $fillable = [
        'user_id',
        'activity_id',
        'learning_program_id',
        'theme_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'id', 'activity_id');
    }

    public function learning_program()
    {
        return $this->belongsTo(LearningProgram::class, 'id', 'learning_program_id');
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'id', 'theme_id');
    }
}
