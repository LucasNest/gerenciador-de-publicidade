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
        Schema::create('cad_publicidade_estado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_publicidade')->constrained('cad_publicidades')->onDelete('cascade');
            $table->foreignId('id_estado')->constrained('cad_estados')->onDelete('cascade');

            $table->unique(['id_publicidade', 'id_estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cad_publicidade_estado');
    }
};
