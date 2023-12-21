<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

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
