<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmActivity extends Model
{
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
