<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'user_id',
        'answers',
        'countRightAnswers',
    ];

    public function activity() {
        return $this->belongsTo(Activity::class);
    }


    public function user() {
        return $this->belongsTo(User::class);
    }
}
