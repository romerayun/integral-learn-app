<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Answer extends Model
{
    use HasFactory;
    use LogsActivity;


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('answer');
    }

    protected $fillable = [
        'answer',
        'isCorrect',
        'question_id',
    ];


    public function question() {
        return $this->belongsTo(Question::class);
    }
}
