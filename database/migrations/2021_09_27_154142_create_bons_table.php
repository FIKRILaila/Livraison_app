<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bons', function (Blueprint $table) {
            $table->id();
            $table->string('ref');
            $table->string('type');
            $table->string('etat')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('magasin_retour')->nullable();
            $table->foreign('magasin_retour')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('livreur_id')->nullable();
            $table->foreign('livreur_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bons');
    }
}