<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LearningProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'annotation',
        'working_program',
    ];

    public function groups() : BelongsToMany {
        return $this->belongsToMany(Group::class, 'group_learning_programs');
    }

    public function themes() : BelongsToMany {
        return $this->belongsToMany(Theme::class, 'learning_program_themes')->orderByPivot('order', 'asc');
    }
}
