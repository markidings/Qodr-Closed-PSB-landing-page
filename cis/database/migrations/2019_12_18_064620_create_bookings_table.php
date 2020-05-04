<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('packet_id')->nullable();
            $table->unsignedBigInteger('public_id');
            $table->string('total_booking');
            $table->string('address');
            $table->string('city_id');
            $table->string('time_slaughter')->nullable();
            $table->string('no_nota');
            $table->integer('no_whatsapp');
            $table->string('name_aqiqah');
            $table->string('name_father');
            $table->string('name_mother');
            $table->string('address_packet');
            $table->string('time_packet');
            $table->string('type_booking');
            $table->string('snack_id');
            $table->string('shipping_charge');
            $table->string('total_purchase');
            $table->string('status_purchase')->nullable();
            $table->string('status_processing')->nullable();
            $table->string('image_processing')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('bookings');
    }
}
