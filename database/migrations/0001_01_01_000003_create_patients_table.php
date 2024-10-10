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
        Schema::create('patients', function (Blueprint $table) {
            $table->id('id');
            $table->integer('code');
            $table->string('name');           
            $table->date('birth_at')->nullable();
            $table->string('guide');
            $table->date('admission_at')->nullable();
            $table->date('departure_at')->nullable();
            $table->enum('status', ['VALIDO', 'INVALIDO']); 
            $table
                ->date('created_at')
                ->useCurrent()
                ->nullable();
            $table
                ->date('updated_at')
                ->useCurrent()
                ->nullable();         
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
