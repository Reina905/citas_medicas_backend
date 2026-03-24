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
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id('expediente_id');
            $table->foreignId('paciente_id')->unique()->constrained('pacientes', 'paciente_id')->onDelete('cascade');
            $table->string('tipo_sangre');
            $table->text('alergias')->nullable();
            $table->text('condiciones')->nullable();
            $table->text('medicaciones')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};
