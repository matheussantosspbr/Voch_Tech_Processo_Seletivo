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
        Schema::create('bandeiras', function (Blueprint $table) {
            $table->uuid('id_bandeira')->primary();
            $table->string('nome');
            $table->uuid('id_grupo_economico');
            $table->foreign('id_grupo_economico')
                ->references('id_grupo_economico')
                ->on('grupos_economicos')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bandeiras');
    }
};
