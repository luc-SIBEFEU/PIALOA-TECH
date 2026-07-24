<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stagiaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email')->unique();
            $table->date('periode_debut');
            $table->date('periode_fin')->nullable();
            $table->string('secteur');
            $table->string('description');
            $table->string('rapport')->nullable();
            $table->string('avatar')->nullable();
            $table->enum('statut', ['termine', 'en_cours'])->default('en_cours');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stagiaires');
    }
};
