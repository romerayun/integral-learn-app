<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningProgramTheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'theme_id',
        'learning_program_id',
        'order'
    ];
}
