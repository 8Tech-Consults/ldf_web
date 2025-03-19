<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('tag_number')->nullable();
            $table->text('farm_id')->nullable();
            $table->text('farm_text')->nullable();
            $table->text('owner_id')->nullable();
            $table->text('owner_text')->nullable();
            $table->text('breed_id')->nullable();
            $table->text('breed_text')->nullable();
            $table->text('parents')->nullable();
            $table->text('dob')->nullable();
            $table->text('date_of_weaning')->nullable(); 
            $table->text('name')->nullable();
            $table->text('photo')->nullable();
            $table->text('sex')->nullable();
            $table->text('district_id')->nullable();
            $table->text('district_text')->nullable();
            $table->text('sub_county_id')->nullable();
            $table->text('sub_county_text')->nullable();
            $table->text('weight')->nullable();
            $table->string('type')->nullable()->default('Cattle');
            $table->string('status')->nullable()->default('Alive');
            $table->text('general_remarks')->nullable();
            $table->text('health_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals');
    }
}
