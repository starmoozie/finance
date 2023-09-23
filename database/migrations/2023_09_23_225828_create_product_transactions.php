<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('parent_id')->index()->nullable();
            $table->uuid('product_id')->index();
            $table->uuid('transaction_id')->index();
            $table->string('qty', 15);
            $table->string('stock', 15);
            $table->string('buy_price', 15);
            $table->string('sell_price', 15);
            $table->string('total_price', 15);
            $table->boolean('type_profit');
            $table->string('amount_profit', 15);
            $table->string('calculated_profit', 15);
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('product_transactions');
    }
}
