<?php

namespace App\Models;

use App\Models\User;
use App\Models\TravelPlace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDestination extends Model
{
    use HasFactory;

    protected $table = 'usersTrips';
    protected $fillable = [
        'user_id',
        'destination_id',
        'destination_name',
        'name',
        'last_name',
        'starting_trip',
        'ending_trip',
        'adult_number',
        'children_number',
        'confirmed',
    ];
    
    public function users()
    {
        return $this->belongsTo(User::class, 'destination_id');
    }

    public function travel_places()
    {
        return $this->belongsTo(TravelPlace::class, 'destination_id');
    }
}
