<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\TeacherSetting;
use App\Models\StudentDetail;
use App\Models\Credit;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'reffer_code',
        'google_id',
        'facebook_id',
        'user_type'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function TeacherSetting()
    {
        return $this->hasOne(TeacherSetting::class,'user_id','id');
    }

    public function StudentDetail()
    {
        return $this->hasOne(StudentDetail::class,'user_id','id');
    }

    public function Credit()
    {
        return $this->hasMany(Credit::class,'user_id','id');
    }
}
