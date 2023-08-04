<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Location extends Model
{
    use HasFactory, ApiTrait;
    protected $fillable = ['name','type','dimension','slug'];
    protected $allowIncluded = ['characters','characters.locations', 'characters.episodes'];
    protected $allowFilter = ['id','name','type','dimension','slug'];
    protected $allowSort = ['id','name','type','dimension','slug'];
    //Relación uno a muchos
    public function characters(){
        return $this->belongsToMany(Character::class);
    }
}
