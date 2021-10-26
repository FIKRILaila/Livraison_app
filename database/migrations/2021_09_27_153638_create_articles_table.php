<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('reference');
            $table->string('image');

            $table->string('variante1')->nullable();
            $table->string('valeur1')->nullable();
            $table->string('variante2')->nullable();
            $table->string('valeur2')->nullable();
            $table->string('variante3')->nullable();
            $table->string('valeur3')->nullable();
            $table->string('variante4')->nullable();
            $table->string('valeur4')->nullable();

            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('articles');
    }
}