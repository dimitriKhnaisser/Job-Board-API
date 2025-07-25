<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded=[];
    protected $table='applications';
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function job(){
        return $this->belongsTo(Job::class);
    }
}
