<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();

            $table->string('pais');
            $table->string('nombre_empresa');
            $table->string('tipo_empresa');
            $table->string('nit')->unique();
            $table->string('telefono');
            $table->string('correo')->unique();
            $table->integer('cantidad_impuesto');
            $table->string('nombre_impuesto');
            $table->string('moneda');
            $table->string('direccion');
            $table->string('ciudad');
            $table->string('departamento');
            $table->string('codigo_postal');
            $table->text('logo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
