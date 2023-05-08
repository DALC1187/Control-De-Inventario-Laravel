<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventariosArticulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios_articulos', function (Blueprint $table) {
            $table->id();
            $table->integer('idInventario');
            $table->integer('idArticulo');
            $table->integer('cantidadStock');
            $table->integer('cantidad');
            $table->double('costoUnitario', 12,2);
            $table->integer('idPromocion')->nullable();
            $table->integer('cantidadPromocion')->nullable();
            $table->double('costoPromocion', 12,2)->nullable();
            $table->integer('cantidadVenta')->default(0);
            $table->double('subtotalVenta', 12,2)->default(0.00);
            $table->double('totalVenta', 12,2)->default(0.00);
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
        Schema::dropIfExists('inventarios_articulos');
    }
}
