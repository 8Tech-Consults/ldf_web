<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeImproveFarms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('farms', function (Blueprint $table) {
            $columns = [
                'name',
                'coordinates',
                'location_id',
                'location_text',
                'village',
                'parish',
                'zone',
                'livestock_type',
                'production_type',
                'date_of_establishment',
                'size',
                'profile_picture',
                'number_of_livestock',
                'number_of_workers',
                'land_ownership',
                'no_land_ownership_reason',
                'general_remarks', 
                'owner_text',
                'created_at',
                'updated_at',
                'district_id',
                'district_text',
                'sub_county_id',
                'sub_county_text',
            ];

            Schema::table('farms', function (Blueprint $table) use ($columns) {
                foreach ($columns as $column) {
                    if (Schema::hasColumn('farms', $column)) {
                        // If the column exists, change it to text & nullable
                        $table->text($column)->nullable()->change();
                    } else {
                        // If it doesn't exist, create it as text & nullable
                        $table->text($column)->nullable();
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
        Schema::table('farms', function (Blueprint $table) {
            //
        });
    }
}
