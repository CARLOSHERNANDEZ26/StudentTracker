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
    Schema::create('courses', function (Blueprint $table) {
        $table->id();
        $table->string('course_code')->unique(); // Ensure this matches line 19 in your Controller
        $table->string('course_name');
        $table->string('schedule_days');
        $table->string('schedule_time');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
