<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupLearningProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'learning_program_id',
    ];
}
