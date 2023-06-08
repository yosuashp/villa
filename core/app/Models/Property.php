<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Property extends Model
{

    protected $casts = [
        'extra_features' => 'object',
        'images'          => 'object'
    ];

    protected $hidden = ['description','map_url'];


    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }


    public function bookedProperties()
    {
        return $this->hasMany(BookedProperty::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function bookedRooms()
    {
        return $this->hasMany(BookedRoom::class);
    }

    public function review(){
        return $this->hasOne(Review::class);
    }

    public function roomCategories()
    {
        return $this->hasMany(RoomCategory::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}
