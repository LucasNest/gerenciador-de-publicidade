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
        Schema::create('cad_publicidades', function (Blueprint $table) {
            $table->id();
            $table ->string('titulo');
            $table ->text('descricao');
            $table ->binary('imagen');
            $table ->string('botao_link');
            $table ->string('titulo_botao_link');
            $table ->date('dt_inicio');
            $table ->date('dt_fim');

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cad_publicidades');
    }
};
