<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmActivity extends Model
{

    //boot
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $farm = Farm::find($model->farm_id);
            if ($farm == null) {
                throw new \Exception("Farm not found");
            }
            $model->user_id = $farm->owner_id;
        });
    }

    //appends for farm_text, owner_text, breed_text
    protected $appends = ['farm_text'];

    //getter for farm_text
    public function getFarmTextAttribute()
    {
        $farm = Farm::find($this->farm_id);
        if ($farm == null) {
            return "N/A";
        }
        return $farm->name;
    }
 

    use HasFactory;
    protected $fillable = [

        'farm_id',
        'start',
        'end',
        'title',
        'user_id',
        'description',

    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
