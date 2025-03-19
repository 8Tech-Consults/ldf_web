<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColsOfProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) { 
            $table->text('name')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->string('manufacturer')->nullable()->change();
            $table->bigInteger('price')->nullable()->change();
            $table->integer('quantity_available')->nullable()->change();
            $table->text('expiry_date')->nullable()->change();
            $table->text('storage_conditions')->nullable()->change();
            $table->text('usage_instructions')->nullable()->change();
            $table->text('warnings')->nullable()->change();
            $table->string('status')->nullable()->change()->default('Active');
            $table->text('image')->nullable()->change();
            $table->integer('stock')->nullable()->change();
            $table->text('category')->nullable()->change(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
