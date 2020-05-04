<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfitMitras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('profit_mitras', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->unsignedBigInteger('paket_id');
            $table->string('profit_nominal');
            $table->string('profit_percent');
            $table->string('selling_price');
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
        Schema::dropIfExists('profit_mitras');
    }
}
