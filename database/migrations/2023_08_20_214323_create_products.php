<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\LengthContant;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary;
            $table->uuid('product_category_id')->index()->nullable();
            $table->uuid('seller_id')->index()->nullable();
            $table->string('code', LengthContant::MAX_CODE)->index()->unique();
            $table->string('created_by', 14)->index();
            $table->string('name', LengthContant::MAX_NAME);
            $table->string('stock', LengthContant::MAX_NUMERIC)->nullable();
            $table->string('buy_price', LengthContant::MAX_NUMERIC)->nullable();
            $table->string('sell_price', LengthContant::MAX_NUMERIC)->nullable();
            $table->json('details')->nullable();
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
        Schema::dropIfExists('products');
    }
}
