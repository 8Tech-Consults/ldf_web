<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToAdminUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            Schema::table('admin_users', function (Blueprint $table) {
                $columns = [
                    'username',
                    'email',
                    'password',
                    'name',
                    'avatar',
                    'remember_token',
                    'created_at',
                    'updated_at',
                    'phone_number_1',
                    'title',
                    'category',
                    'first_name',
                    'last_name',
                    'nin',
                    'district_id',
                    'district_text',
                    'sub_county_id',
                    'sub_county_text',
                    'coordinates',
                    'village',
                    'group_or_practice',
                    'license_number',
                    'license_expiry_date',
                    'date_of_registration',
                    'brief_profile',
                    'business_phone_number',
                    'postal_address',
                    'services_offered',
                    'license_photo',
                    'nin_photo',
                    'other_documents',
                    'status',
                    'gender',
                    'number_of_dependants',
                    'farmer_group',
                    'primary_phone_number',
                    'secondary_phone_number',
                    'is_land_owner',
                    'land_ownership',
                    'production_scale',
                    'access_to_credit',
                    'credit_institution',
                    'date_started_farming',
                    'highest_level_of_education',
                    'marital_status'
                ];

                foreach ($columns as $column) {
                    if (!Schema::hasColumn('admin_users', $column)) {
                        $table->text($column)->nullable()->after('id');
                    }
                }
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            //
        });
    }
}
