<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_records', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('farm_id')->nullable();
            $table->string('transaction_type')->nullable();
            $table->date('transaction_date')->nullable();
            $table->text('description')->nullable()->nullable();
            $table->decimal('amount', 15,0)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('party')->nullable();
            $table->string('party_tin')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('reciept_file')->nullable();
            $table->text('remarks')->nullable();
            $table->text('created_by_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_records');
    }
}
