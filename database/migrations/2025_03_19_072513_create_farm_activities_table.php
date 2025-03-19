<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farm_activities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('farm_id')->nullable();
            $table->text('farm_text')->nullable();
            $table->text('name')->nullable();
            $table->text('scheduled_at')->nullable();
            $table->text('description')->nullable();
            $table->text('user_id')->nullable();
            $table->text('user_text')->nullable(); 
            $table->text('type')->nullable();
            $table->text('status')->nullable();
            $table->text('outcome')->nullable();
            $table->text('photos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farm_activities');
    }
}
