<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    //booot
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $farm = Farm::find($model->farm_id);
            if ($farm == null) {
                throw new \Exception("Farm not found");
            }
            $model->district_id = $farm->district_id;
            $model->sub_county_id = $farm->location_id;
            $model->owner_id = $farm->owner_id;
            $model->breed_id = $model->breed_id == "" ?? 1;
        });
    }

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

    //appends for farm_text, owner_text, breed_text
    protected $appends = ['farm_text', 'owner_text', 'breed_text'];

    //getter for farm_text
    public function getFarmTextAttribute()
    {
        $farm = Farm::find($this->farm_id);
        if ($farm == null) {
            return "N/A";
        }
        return $farm->name;
    }

    //getter for owner_text
    public function getOwnerTextAttribute()
    {
        $owner = User::find($this->owner_id);
        if ($owner == null) {
            return "N/A";
        }
        return $owner->name;
    }

    //getter for breed_text
    public function getBreedTextAttribute()
    {
        $breed = Breed::find($this->breed_id);
        if ($breed == null) {
            return "N/A";
        }
        return $breed->name;
    }
}
