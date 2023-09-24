<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\LengthContant;

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
            $table->string('qty', LengthContant::MAX_NUMERIC);
            $table->string('stock', LengthContant::MAX_NUMERIC);
            $table->string('buy_price', LengthContant::MAX_NUMERIC);
            $table->string('sell_price', LengthContant::MAX_NUMERIC);
            $table->string('total_price', LengthContant::MAX_NUMERIC);
            $table->boolean('type_profit');
            $table->string('amount_profit', LengthContant::MAX_NUMERIC);
            $table->string('calculated_profit', LengthContant::MAX_NUMERIC);
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
