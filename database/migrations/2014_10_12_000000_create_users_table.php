<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('nomComplet');
            $table->string('nomMagasin')->nullable();
            $table->string('logo')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->string('adresse')->nullable();
            $table->string('cin')->nullable();
            $table->string('RIP')->nullable();
            $table->string('ville')->nullable();
            $table->enum('role',['client','livreur','admin']);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->rememberToken();
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
