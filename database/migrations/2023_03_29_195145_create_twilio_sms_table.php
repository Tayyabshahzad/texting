<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwilioSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twilio_sms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sid', 500);
            $table->enum('direction', ['sent', 'received']);
            $table->string('from', 50);
            $table->string('to', 50);
            $table->string('body', 1600)->nullable()->default(null);
            $table->enum('status', ['request_error', 'accepted', 'queued', 'sending', 'sent', 'receiving', 'received', 'delivered', 'undelivered', 'failed', 'read'])->default('request_error');
            $table->unsignedInteger('to_user_id');
            $table->unsignedInteger('coupon_id');

            // Indexes
            $table->unique(['sid']);
            $table->index(['from']);
            $table->index(['to']);

            $table->timestamps();


            $table->foreign('to_user_id')
                ->references('id')->on('users')
                ->onDelete('no action')->onUpdate('no action');

            $table->foreign('coupon_id')
                ->references('id')->on('coupons')
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
        Schema::dropIfExists('twilio_sms');
    }
}
