<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'surname',
        'name',
        'patron',
        'phone',
        'series_passport',
        'number_passport',
        'date_of_birth',
        'snils',
        'sex',
        'nationality',
        'password',
        'email',
        'is_email_verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('users');
    }

//    public function role() {
//        return $this->belongsTo(Role::class);
//    }

    public function groups() : BelongsToMany {
        return $this->belongsToMany(Group::class, 'group_users')->withPivot('id');
    }

    public function getFullName() {
        return $this->surname . " " . $this->name . " " . $this->patron;
    }

    public function getPassport() {
        if (empty($this->series_passport) || empty($this->number_passport)) {
            return '<span class="text-danger">Не заполнено</span>';
        }
        return $this->series_passport . " №" . $this->number_passport;
    }
}
