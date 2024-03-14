<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Activity extends Model
{
    use HasFactory;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('activity');
    }

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

    public function complete() {
        return $this->hasMany(CompleteActivity::class, 'activity_id', 'id');
    }
}
