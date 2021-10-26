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
            $table->string('quartier');
            $table->integer('prix');
            $table->string('commentaire')->nullable();
            $table->string('natureProduit')->nullable();
            $table->boolean('refuser')->default(false);
            $table->boolean('annuler')->default(false);
            $table->boolean('ouvrir')->default(false);
            $table->boolean('fragile')->default(false);
            $table->boolean('remplacer')->default(false);
            $table->boolean('change')->default(false);
            $table->boolean('frais_change')->default(false);
            $table->boolean('paye')->default(false);
            $table->boolean('enregistre')->default(false);
            $table->boolean('bonPaiment')->default(false);
            $table->string('etat');
            $table->date('reported_at')->nullable();
            $table->unsignedBigInteger('ville_id');
            $table->foreign('ville_id')->references('id')->on('villes')->onDelete('cascade');
            $table->unsignedBigInteger('article_id')->nullable();
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('change_id')->nullable();
            $table->foreign('change_id')->references('id')->on('colis');
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