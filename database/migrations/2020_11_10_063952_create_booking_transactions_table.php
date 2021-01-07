<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateBookingTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('amount');
            $table->unsignedInteger('discounted_amount')->nullable();
            $table->integer('reservation_id');
            $table->enum('status',['SUCCESS','FAILED','CANCELLED','PENDING'])->default('PENDING');
            $table->json('payment_initiation_server_response')->nullable();
            $table->json('payment_validation_server_response')->nullable();
            $table->enum('paid_by',['Cash','Online Payment'])->nullable();
            $table->boolean('is_payment_done')->default(false);
            $table->boolean('is_delete')->default(0);
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
        Schema::dropIfExists('booking_transactions');
    }
}
