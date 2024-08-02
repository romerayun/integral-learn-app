<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalQuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'learning_program_id',
        'final_quiz_id',
        'user_id',
        'answers',
        'countRightAnswers',
    ];

    public function learningProgram() {
        return $this->belongsTo(LearningProgram::class);
    }

    public function finalQuiz() {
        return $this->belongsTo(FinalQuiz::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
