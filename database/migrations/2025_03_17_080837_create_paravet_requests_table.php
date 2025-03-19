<?php

use App\Models\District;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParavetRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //check if paravet_requests table exists and drop it
        if (Schema::hasTable('paravet_requests')) {
            Schema::dropIfExists('paravet_requests');
        }

        Schema::create('paravet_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(User::class, 'paravet_id');
            $table->foreignIdFor(User::class, 'farmer_id');
            $table->foreignIdFor(Location::class, 'district_id')->nullable();
            $table->text('farmer_preferred_date')->nullable();
            $table->string('status')->default('Pending');
            $table->string('application_mail_sent_to_vet')->default('No');
            $table->string('review_mail_sent_to_farmer')->default('No');
            $table->text('farmer_message')->nullable();
            $table->text('paravet_message')->nullable();
            $table->text('farmer_feedback_comment')->nullable();
            $table->integer('farmer_feedback_rating')->nullable();
            $table->text('activity_type')->nullable();
            $table->text('activity_address')->nullable();
            $table->text('gps')->nullable();
            $table->text('activity_description')->nullable();
            $table->text('activity_date')->nullable();
            $table->text('activity_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paravet_requests');
    }
}
