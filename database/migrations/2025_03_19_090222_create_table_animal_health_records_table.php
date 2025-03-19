<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAnimalHealthRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_health_records', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date')->nullable();
            $table->string('record_type')->nullable(); // e.g., 'Treatment' or 'Diagnosis'
            $table->unsignedBigInteger('animal_id')->nullable(); // references an Animal
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->string('status')->nullable(); // e.g., 'Sick', 'Healthy', etc.

            // Additional references
            $table->unsignedBigInteger('recorded_by')->nullable(); // user who recorded it
            $table->unsignedBigInteger('owner_id')->nullable();    // owner of the animal
 
 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animal_health_records');
    }
}
