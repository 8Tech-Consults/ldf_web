<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicatant_id'); //TODO("applicant_id instead of applicatant_id")
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function farms()
    {
        return $this->hasMany(Farm::class);
    }

    public function statuses()
    {
        return $this->morphMany(Status::class, 'statusable');
    }

    public function latestStatus()
    {
        return $this->morphOne(Status::class, 'statusable')->latestOfMany();
    }

    public function profilePhoto()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function inspectingAgent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
