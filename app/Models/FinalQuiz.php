<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalQuiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'learning_program_id',
        'key',
        'isActive',
        'countQuestions'
    ];


    public function learningProgram() {
        return $this->belongsTo(LearningProgram::class);
    }

    public function finalQuizResult() {
        return $this->hasMany(FinalQuizResult::class);
    }
}
