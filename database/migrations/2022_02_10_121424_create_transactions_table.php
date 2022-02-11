<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->index();
            $table->integer('subtotal')->nullable();
            $table->float('tax', 8, 2)->nullable();
            $table->float('coupon', 8, 2)->nullable();
            $table->integer('total')->nullable();
            $table->integer('status')->default(1)->comment('1=pending,2=processing,3=served,0=cancelled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
