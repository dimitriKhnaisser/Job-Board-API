<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='positions';
    
    public function user(){
        return $this->belongsTo(User::class);
    } 
    public function company(){
        return $this->belongsTo(Company::class);
    }
     public function type(){
        return $this->belongsTo(Type::class);
    }
}
