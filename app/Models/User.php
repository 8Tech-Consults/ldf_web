<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Encore\Admin\Auth\Database\Administrator;
use DB;
use App\Models\AdminRole;

class User extends Administrator
{
    protected $table = 'admin_users';

    public static function getAgents()
    {
        return User::whereHas('roles', function ($query) {
            $query->where('slug', 'agent');
        })->get();
    }

    public function assignRole(String $role, bool $clearPrevious = true)
    {
        $role = AdminRole::where('slug', $role)->first();

        if ($clearPrevious) {
            DB::table('admin_role_users')->where('user_id', $this->id)->delete();
        }
        DB::table('admin_role_users')->insert([
            'role_id' => $role->id,
            'user_id' => $this->id
        ]);
    }

    // public function hasRole(String $role) 
    // {
    //     $role = AdminRole::where('slug', $role)->first();
    //     return DB::table('admin_role_users')->where([
    //         'role_id' => $role->id,
    //         'user_id' => $this->id
    //     ])->exists();

    // }

    public function farmersInspected()
    {
        return $this->hasMany(Farmer::class, 'agent_id');
    }
}
