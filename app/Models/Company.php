<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Model
{
        use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'password',
        'remember_token',
    ];
     protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    protected $guarded=[];
    protected $table='companies';
    use HasFactory;

    public function industry(){
        return $this->belongsTo(Industry::class);
    }
    public function jobs(){
        return $this->hasMany(Job::class);
    }
    public function positions(){
        return $this->hasMany(Position::class);
    }
}
