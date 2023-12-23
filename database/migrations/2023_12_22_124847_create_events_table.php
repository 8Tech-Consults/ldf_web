<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('animal_id')->nullable();
            $table->integer('owner_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('sub_county_id')->nullable();
            $table->integer('disease_id')->nullable();
            $table->integer('farm_id')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('milk')->nullable();
            $table->string('type')->nullable();
            $table->text('detail')->nullable();
            $table->text('description')->nullable();
            $table->text('drug')->nullable();
            $table->text('vaccine')->nullable();
            $table->text('photo')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
