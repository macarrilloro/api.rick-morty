<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Character extends Model
{
    use HasFactory, ApiTrait;
    const ALIVE = 1;
    const DEAD = 2;
    const UNKNOWN = 3;
    protected $fillable = ['name','status','species','type','gender','slug','location_id','user_id'];
    //Relación uno a muchos inversa
    public function user(){
        return $this->belongsTo(User::class);
    }
    //Relación uno a muchos
    public function locations(){
        return $this->belongsToMany(Location::class);
    }
    //Relación muchos a muchos
    public function episodes(){
        return $this->belongsToMany(Episode::class);
    }

    //relación uno a uno polimorfica
    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

    //relación uno a uno
    public function origin(){
        return $this->hasOne(Location::class);
    }

}
