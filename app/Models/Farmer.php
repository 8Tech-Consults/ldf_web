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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
           
        });

          //call back to send a notification to the user
          self::created(function ($model) 
          {
              Notification::send_notification($model, 'Farmer', request()->segment(count(request()->segments())));
          });

            //call back to send a notification to the user
            self::updated(function ($model) 
            {
                Notification::update_notification($model, 'Farmer', request()->segment(count(request()->segments())-1));
                
                if($model->status == 'approved'){
                    AdminRoleUser::where([
                        'user_id' => $model->user_id
                    ])->delete();
                    $new_role = new AdminRoleUser();
                    $new_role->user_id = $model->user_id;
                    $new_role->role_id = 3;
                    $new_role->save();
                }
            });

    }
}
