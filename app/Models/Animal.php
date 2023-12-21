<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    public function healthRecords()
    {
        return $this->hasMany(AnimalHealthRecord::class);
    }

    public function vectorAndDiseases()
    {
        return $this->hasMany(VectorAndDisease::class);
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    
}