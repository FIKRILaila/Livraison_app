<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineBonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_bons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bon_id');
            $table->foreign('bon_id')->references('id')->on('bons')->ondelete('cascade');
            $table->unsignedBigInteger('colis_id');
            $table->foreign('colis_id')->references('id')->on('colis')->ondelete('cascade');
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
        Schema::dropIfExists('line_bons');
    }
}
