<?php

namespace App\Models;

use App\Models\UserDestination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelPlace extends Model
{
    protected $table = 'travel_places';

    protected $fillable = [
        'name', 'stars','travelTime', 'image', 'description','price', 'created_at'
    ];
    use HasFactory;
    
    public function galeries()
    {
        return $this->hasMany(Galerie::class);
    }


    public function userDestination()
    {
        return $this->hasMany(UserDestination::class);
    }

}
