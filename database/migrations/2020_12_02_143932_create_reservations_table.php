<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('booking_date');
            $table->unsignedInteger('category_id');
            $table->integer('category_price');
            $table->integer('adult');
            $table->integer('child_under_120_cm');
            $table->integer('child_under_132_cm');
            $table->longText('address');
            $table->text('city');
            $table->text('country');
            $table->longText('message')->nullable();
            $table->string('random')->unique();
            $table->enum('discount_type',['GPStar','CityGem','AmEx','EBL','Brac','Authority'])->nullable();
            $table->integer('discount_percent')->nullable();
            $table->boolean('payment_method');
            $table->enum('payment_type',['Card','Cash'])->nullable();
            $table->boolean('is_delete')->default(false);
            $table->string('arrived')->default(false);
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
        Schema::dropIfExists('reservations');
    }
}
