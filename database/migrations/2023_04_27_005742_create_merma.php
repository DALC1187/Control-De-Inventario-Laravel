<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mermas', function (Blueprint $table) {
            $table->id();
            $table->integer('idArticulo');
            $table->integer('cantidad');
            $table->string('tipoMerma');
            $table->string('tipoDano')->nullable();
            $table->string('cambioProveedor')->nullable();
            $table->integer('idArticuloEntregado')->nullable();
            $table->integer('cantidadEntregado')->nullable();
            $table->integer('idInventario')->nullable();
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
        Schema::dropIfExists('mermas');
    }
}
