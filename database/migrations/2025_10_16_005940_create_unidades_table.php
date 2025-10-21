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
        Schema::create('unidades', function (Blueprint $table) {
            $table->uuid('id_unidade')->primary();
            $table->string('nome_fantasia');
            $table->string('razao_social');
            $table->char('cnpj', 14)->unique();
            $table->uuid('id_bandeira');
            $table->foreign('id_bandeira')
                ->references('id_bandeira')
                ->on('bandeiras')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades');
    }
};
