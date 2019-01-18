<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('comment')->nullable();
            $table->string('currency_id', 36)->nullable();
            $table->string('partner_seller_point_id', 36)->nullable();
            $table->enum('status', [
                'CANCELED',
                'USER_CANCELED',
                'ESHOP',
                'SUCCESS',
                'PARTIAL_SUCCESS',
                'FAILURE',
                'IN_PROGRESS',
                'NOT_PROCESSED',
                'ACCEPTED'
            ])->default('NOT_PROCESSED');
            $table->float('total_price');
            $table->index('partner_seller_point_id');
            $table->index('status');
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
        Schema::dropIfExists('orders');
    }
}
