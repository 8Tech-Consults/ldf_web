<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableForCooperativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooperatives', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->text('user_id')->nullable();    // or text if you prefer
            $table->string('name')->nullable();                  // e.g., Cooperative name
            $table->text('location_id')->nullable(); // references sub-county
            $table->text('village')->nullable();
            $table->text('parish')->nullable();
            $table->text('zone')->nullable();
            $table->text('production_type')->nullable();       // from grid
            $table->text('date_of_establishment')->nullable();   // stored as a date
            $table->text('status')->nullable();                // e.g., Pending, Approved, etc.
            $table->text('certification')->nullable();           // e.g., file path
            $table->text('description')->nullable(); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cooperatives');
    }
}
