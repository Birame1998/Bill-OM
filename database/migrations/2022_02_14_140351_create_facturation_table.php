<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturation', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('num_ap');
            $table->string('nom_partenaire', 100);
            $table->string('sim_head', 25);
            $table->integer('transaction_amount');
            $table->double('commission');
            $table->double('a_reverser');
            $table->string('compte_bancaire', 100);
            $table->integer('onglet_facturation_id');
            $table->integer('statut');
            $table->string('date_transaction',50);
            $table->string('motif_rejet_do',250)->nullable();
            $table->string('validation_do',50)->nullable();
            $table->string('rejet_do',50)->nullable();
            $table->string('rejouer',50)->nullable();
            $table->string('valider_par',100)->nullable();
            $table->string('rejeter_par',100)->nullable();
            $table->string('a_afficher',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturation');
    }
}
