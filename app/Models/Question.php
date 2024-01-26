<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Question extends Model
{
    use HasFactory;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('question');
    }

    protected $fillable = [
        'text_question',
        'activity_id',
        'type',
        'image'
    ];

    public function activity() {
        return $this->belongsTo(Activity::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }
}
