<?php

namespace App\Models;

use Encore\Admin\Form\Field\BelongsToMany;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany as RelationsBelongsToMany;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Encore\Admin\Auth\Database\Administrator;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;



    public static function update_rating($id)
    {
        $user = User::find($id);
        $tasks = Task::where('assigned_to', $id)->get();
        $rate = 0;
        $count = 0;
        foreach ($tasks as $task) {
            if ($task->manager_submission_status != 'Not Submitted') {
                $rate += $task->rate;
                $count++;
            }
        }
        if ($count > 0) {
            $rate = $rate / $count;
        }
        $user->rate = $rate;
        $user->save();
    }


    protected $table = "admin_users";

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
}
