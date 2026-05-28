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
        Schema::create('enrollments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relations
            |--------------------------------------------------------------------------
            */

            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('course_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Informations inscription
            |--------------------------------------------------------------------------
            */

            $table->string('academic_year');

            /*
            |--------------------------------------------------------------------------
            | pending
            | validated
            | refused
            |--------------------------------------------------------------------------
            */

            $table->string('status')
                ->default('pending');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Empêcher double inscription
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'student_id',
                'course_id',
                'academic_year'
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};