<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_accounts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('owner_id')->nullable();
            $table->text('name')->nullable();
            $table->text('balance')->nullable();
            $table->text('detail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_accounts');
    }
}
