<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullableColoumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('total_booking')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('city_id')->nullable()->change();
            $table->string('time_slaughter')->nullable()->change();
            $table->string('no_nota')->nullable()->change();
            $table->string('name_aqiqah')->nullable()->change();
            $table->string('name_father')->nullable()->change();
            $table->string('name_mother')->nullable()->change();
            $table->string('address_packet')->nullable()->change();
            $table->string('time_packet')->nullable()->change();
            $table->string('type_booking')->nullable()->change();
            $table->string('snack_id')->nullable()->change();
            $table->string('shipping_charge')->nullable()->change();
            $table->string('total_purchase')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
}
