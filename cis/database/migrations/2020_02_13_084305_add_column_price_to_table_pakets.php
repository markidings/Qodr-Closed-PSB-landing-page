<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPriceToTablePakets extends Migration
{
    public function up()
    {
        Schema::table('pakets', function (Blueprint $table) {
            $table->string('price');
        });
    }

    public function down()
    {
        Schema::table('pakets', function (Blueprint $table) {
            //
        });
    }
}
