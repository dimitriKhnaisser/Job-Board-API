<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $guarded=[];
    protected $table='industries';
    use HasFactory;

    public function users(){
        return $this->hasMany(User::class);
    }
    public function companies(){
        return $this->hasMany(Company::class);
    }
}
