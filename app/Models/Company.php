<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded=[];
    protected $table='companies';
    use HasFactory;

    public function industry(){
        return $this->belongsTo(Industry::class);
    }
    public function jobs(){
        return $this->hasMany(Job::class);
    }
}
