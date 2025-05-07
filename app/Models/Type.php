<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $guarded=[];
    protected $table='types';
    use HasFactory;
    
    public function jobs(){
        return $this->hasMany(Job::class);
    }
}
