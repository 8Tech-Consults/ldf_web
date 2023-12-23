<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    //getter for name
    public function getNameAttribute($value)
    {
        if ($this->details != 'Subcounty') {
            return ucwords($value);
        }
        $parent = Location::find($this->parent);
        if ($parent == null) {
            return ucwords($value);
        }
        return ucwords($parent->name . ", " . $value);
    }
}
