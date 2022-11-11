<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogueHasSimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('catalogue_has_sim', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('catalogue_id');
            $table->foreign('catalogue_id')->references('id')->on('catalogue');
            $table->string('sim_head', 25)->unique();
            $table->string('identifiant_designation', 150)->nullable();
            $table->integer('onglet_facturation_id');
            $table->integer('blacklist_c2c');
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
        Schema::dropIfExists('catalogue_has_sim');
    }
}
