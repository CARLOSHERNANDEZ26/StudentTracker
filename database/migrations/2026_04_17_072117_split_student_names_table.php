<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{

    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('last_name')->after('student_id');
            $table->string('first_name')->after('last_name');
            $table->string('middle_name')->nullable()->after('first_name');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('name')->after('student_id');
            $table->dropColumn(['last_name', 'first_name', 'middle_name']);
        });
    }
}; 