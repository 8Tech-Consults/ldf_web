<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivestockType extends Model
{
    use HasFactory;

    public function setImagesAttribute($Images)
{
    if (is_array($Images)) {
        $this->attributes['Images'] = json_encode($Images);
    }
}

public function getImagesAttribute($Images)
{
    return json_decode($Images, true);
}

    public function breeds()
    {
        return $this->hasMany(Breed::class);
    }
}
