<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'count_hours',
        'content',
        'type_id',
    ];

    public function type() {
        return $this->belongsTo(ActivityType::class);
    }

    public function themes() : BelongsToMany {
        return $this->belongsToMany(Theme::class, 'activity_themes');
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }
}
