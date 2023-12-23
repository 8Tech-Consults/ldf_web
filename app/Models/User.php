<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Encore\Admin\Auth\Database\Administrator;
use App\Models\AdminRole;
use Illuminate\Support\Facades\DB;

class User extends Administrator
{
    protected $table = 'admin_users';

    //boot
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $phone_number = $model->phone_number_1;
            $phone_number = Utils::prepare_phone_number($phone_number);
            if (!Utils::phone_number_is_valid($phone_number)) {
                throw new \Exception("Invalid phone number $phone_number.");
            }
            $model->phone_number_1 = $phone_number;
            $oldUser = User::where('phone_number_1', $phone_number)->first();
            if ($oldUser != null) {
                throw new \Exception("Phone number already registered");
            }
            $email = $model->email;
            //check if email is valid
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $model->email = $email;
                $model->username = $email;
            }

            if (strlen($model->username) < 2 && strlen($model->email) == 0) {
                $model->username = $phone_number;
            }

            if (strlen($model->username) < 2) {
                throw new \Exception("Invalid username"); 
            }

            //get user with same email
            $oldUser = User::where('email', $email)->first();
            if ($oldUser != null) {
                throw new \Exception("Email already registered");
            }

            //get user with same username
            $oldUser = User::where('username', $email)->first();
            if ($oldUser != null) {
                throw new \Exception("Username already registered");
            }

            $sub_county = Location::find($model->sub_county_id);
            if ($sub_county == null) {
                throw new \Exception("Sub county not found");
            }
            $model->district_id = $sub_county->parent;
        });
    }



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

    //appends for district_text, sub_county_text
    protected $appends = ['district_text', 'sub_county_text'];
    //getter for district_text
    public function getDistrictTextAttribute()
    {
        $district = Location::find($this->district_id);
        if ($district == null) {
            return "N/A";
        }
        return $district->name;
    }
    //getter for sub_county_text
    public function getSubCountyTextAttribute()
    {
        $sub = Location::find($this->sub_county_id);
        if ($sub == null) {
            return "N/A";
        }
        return $sub->name;
    }
}
