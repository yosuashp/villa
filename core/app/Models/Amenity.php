<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    public function roomCategories()
    {
        return $this->belongsToMany(RoomCategory::class, 'amenity_room_categories', 'amenity_id',  'room_category_id')->withTimestamps();
    }
}
