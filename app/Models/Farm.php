<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;


    //boot
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->owner_id = $model->owner_id ?? auth()->user()->id;
            $sub = Location::find($model->location_id);
            if($sub == null){
                throw new \Exception("Location not found");
            }
            $model->district_id = $sub->parent;
        });
    }

    //appends for location_text
    protected $appends = ['sub_county_text'];
    //getter for sub_county_text
    public function getSubCountyTextAttribute()
    {
        $sub = Location::find($this->location_id);
        if ($sub == null) {
            return "N/A";
        }
        return $sub->name;
    }

    protected $guarded = [];

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }


    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function breeds()
    {
        return $this->belongsToMany(Breed::class);
    }

    public function productionRecords()
    {
        return $this->hasMany(ProductionRecord::class);
    }

    public function financialRecords()
    {
        return $this->hasMany(FinancialRecord::class);
    }

    public function animalHealthRecords()
    {
        return $this->hasMany(AnimalHealthRecord::class);
    }

    public function vectorAndDiseases()
    {
        return $this->hasMany(VectorAndDisease::class);
    }

    public function statuses()
    {
        return $this->morphMany(Status::class, 'statusable');
    }

    public function latestStatus()
    {
        return $this->morphOne(Status::class, 'statusable')->latestOfMany();
    }
}
