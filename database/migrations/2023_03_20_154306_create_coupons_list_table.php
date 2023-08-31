<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons_list', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('coupon_id');
            $table->unsignedInteger('user_id');
            $table->integer('redeemed')->default(0);
            $table->dateTime('redeemed_at')->nullable();

            $table->foreign('coupon_id')
                ->references('id')->on('coupons')
                ->onDelete('no action')->onUpdate('no action');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons_list');
    }
}
