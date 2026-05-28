<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['course_id']);
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn(['student_id', 'course_id']);
            $table->foreignId('enrollment_id')->after('id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropForeign(['enrollment_id']);
            $table->dropColumn('enrollment_id');
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->foreignId('student_id')->after('id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->after('student_id')->constrained()->cascadeOnDelete();
        });
    }
};