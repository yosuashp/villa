<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookedProperty extends Model
{
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function bookedRooms()
    {
        return $this->hasMany(BookedRoom::class);
    }
}
