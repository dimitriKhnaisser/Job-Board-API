<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $guarded=[];
    protected $table='jobs';
    use HasFactory;
     
    public function applications(){
        return $this->hasMany(Application::class);
    }
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function type(){
        return $this->belongsTo(Type::class);
    }
    public function user(){
        return $this->hasOne(User::class);
    }
}
