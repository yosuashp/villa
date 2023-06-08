<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{

    public function property() 
    {
        return $this->belongsTo(Property::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function bookedRooms()
    {
        return $this->hasMany(BookedRoom::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'amenity_room_categories', 'room_category_id', 'amenity_id')->withTimestamps();
    }

}
