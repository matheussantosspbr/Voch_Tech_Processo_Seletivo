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
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->uuid('id_colaborador')->primary();
            $table->string('nome');
            $table->string('email');
            $table->string('cpf')->unique();
            $table->uuid('id_unidade');
            $table->foreign('id_unidade')
                ->references('id_unidade')
                ->on('unidades')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaboradores');
    }
};
