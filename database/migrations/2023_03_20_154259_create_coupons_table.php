<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('description');
            $table->date('expiry')->nullable();
            $table->integer('type');
            $table->unsignedInteger('created_by_id');
            $table->unsignedInteger('customer_details_id');
            $table->timestamps();

            $table->foreign('created_by_id')
                ->references('id')->on('users')
                ->onDelete('no action')->onUpdate('no action');

            $table->foreign('customer_details_id')
                ->references('id')->on('customer_details')
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
        Schema::dropIfExists('coupons');
    }
}
