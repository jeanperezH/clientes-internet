<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->foreign('id')->references('id')->on('personas')->onDelete('cascade'); 
            $table->bigInteger('idSede')->unsigned();
            $table->foreign('idSede')->references('id')->on('sedes')->onDelete('cascade');
            $table->string('tipoCliente',50);
            $table->boolean('tieneMiAntena')->default(0);
            $table->float('deuda');
            $table->boolean('condicion')->default(1); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
