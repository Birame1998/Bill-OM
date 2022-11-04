<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom',80)->nullable();
            $table->string('prenom',80)->nullable();
            $table->string('email',80)->unique();
            $table->string('login_windows',80)->unique();
            $table->integer('tentative')->nullable();
            $table->dateTime('date_login')->nullable();
            $table->foreignId('structure_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('date_debut_interim')->nullable();
            $table->date('date_fin_interim')->nullable();
            $table->integer('role_base');
            $table->integer('created_by');
            $table->string('password',100)->default(bcrypt('super'));
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
        Schema::dropIfExists('users');
    }
}
