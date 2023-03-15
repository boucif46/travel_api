<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galerie extends Model
{
    use HasFactory;
    protected $table = 'galeries';

    protected $fillable = [
        'travel_place_id', 'image_url'
    ];

    public function travel_place()
    {
        return $this->belongsTo(TravelPlace::class);
    }
}
