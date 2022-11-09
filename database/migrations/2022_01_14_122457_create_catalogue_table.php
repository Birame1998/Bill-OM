<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogue', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('num_ap')->unique();
            $table->string('nom_partenaire', 100);
            $table->integer('type_partenaire_id');
            $table->integer('inclure_id');
            $table->double('taux_commission');
            $table->string('compte_bancaire', 100);
            $table->integer('mode_reversement_id');
            $table->string('created_by', 100);
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
        Schema::dropIfExists('catalogue');
    }
}
