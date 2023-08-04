<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Episode extends Model
{
    use HasFactory, ApiTrait;

    protected $fillable = ['name','air_date','episode','slug'];
    //Relación muchos a muchos
    public function characters(){
        return $this->belongsToMany(Character::class);
    }
}
