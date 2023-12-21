<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    use HasFactory;

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function livestockType()
    {
        return $this->belongsTo(LivestockType::class);
    }

    public function farms()
    {
        return $this->belongsToMany(Farm::class);
    }
}
