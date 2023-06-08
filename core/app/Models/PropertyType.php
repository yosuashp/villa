<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
