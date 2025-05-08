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
        Schema::create('archivo_eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_original');
            $table->integer('tamaño');
            $table->string('mime');
            $table->foreignId('evento_id')->constrained('eventos');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivo_eventos');
    }
};
