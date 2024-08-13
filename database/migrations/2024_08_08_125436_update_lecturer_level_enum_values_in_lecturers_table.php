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
        Schema::table('lecturers', function (Blueprint $table) {
            $table->dropColumn('lecturer_level');
        });

        Schema::table('lecturers', function (Blueprint $table) {
            $table->enum('lecturer_level', [
                'Head of Department',
                'Senior Lecturer',
                'Dean',
                'Deputy Dean'
            ])->after('department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lecturers', function (Blueprint $table) {
            $table->dropColumn('lecturer_level');
        });

        // Restore the original lecturer_level enum values
        Schema::table('lecturers', function (Blueprint $table) {
            $table->enum('lecturer_level', [
                'Head of Department',
                'Senior Lecturer',
                'Dean',
                'Deputy Dean'
            ])->after('department');
        });
    }
};
