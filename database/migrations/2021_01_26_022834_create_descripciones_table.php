<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescripcionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descripciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idAntena')->unsigned();
            $table->foreign('idAntena')->references('id')->on('antenas')->onDelete('cascade');
            $table->string('descripcion',250);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descripciones');
    }
}
