<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historiques', function (Blueprint $table) {
            $table->id();
            $table->string('etat_h');
            $table->unsignedBigInteger('par');
            $table->foreign('par')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('colis_id');
            $table->foreign('colis_id')->references('id')->on('colis')->onDelete('cascade');
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
        Schema::dropIfExists('historiques');
    }
}