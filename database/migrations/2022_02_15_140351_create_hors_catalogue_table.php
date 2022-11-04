<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorsCatalogueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hors_catalogue', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('parent_user_msisdn');
            $table->integer('transaction_amount');
            $table->string('date_transaction',50);
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
        Schema::dropIfExists('hors_catalogue');
    }
}
