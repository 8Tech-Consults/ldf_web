<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    //booot
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $animal = Animal::find($model->animal_id);
            if ($animal == null) {
                throw new \Exception("Animal not found");
            }
            $model->weight = (int)($model->weight);
            $model->milk = (int)($model->milk);
            $model->district_id = $animal->district_id;
            $model->sub_county_id = $animal->sub_county_id;
            $model->disease_id = $animal->disease_id;
            $model->owner_id = $animal->owner_id;
            $model->farm_id = $animal->farm_id;
        });
    }
}
