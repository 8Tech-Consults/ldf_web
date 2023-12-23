<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceAccount extends Model
{
    use HasFactory;
    //boot
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->owner_id = $model->owner_id ?? auth()->user()->id;
        });
    }
}
