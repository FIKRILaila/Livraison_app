<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colis', function (Blueprint $table) {
            $table->id();
            $table->text('code_bar')->unique()->nullable();
            $table->string('destinataire');
            $table->string('code');
            $table->string('telephone');
            $table->string('adresse');
            $table->string('commentaire')->nullable();
            $table->string('quartier');
            $table->integer('prix');
            $table->boolean('ouvrir'); 
            $table->boolean('valide'); 
            $table->boolean('fragile');
            $table->boolean('change');
            $table->boolean('paye');
            $table->string('etat');
            $table->unsignedBigInteger('ville_id');
            $table->foreign('ville_id')->references('id')->on('villes')->ondelete('cascade');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('users')->ondelete('cascade');
            $table->unsignedBigInteger('livreur_id')->nullable();
            $table->foreign('livreur_id')->references('id')->on('users')->ondelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colis');
    }
}
