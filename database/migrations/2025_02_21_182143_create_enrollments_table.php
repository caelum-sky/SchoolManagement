<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentsTable extends Migration
{
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            
            // Enrollment status (Default: 'Enrolled')
            $table->string('status')->default('Enrolled');

            // Schedule fields
            $table->string('schedule_day'); // Monday, Tuesday, etc.
            $table->time('schedule_start_time'); // e.g., 13:00 for 1:00 PM
            $table->time('schedule_end_time'); // e.g., 15:00 for 3:00 PM

            $table->timestamps(); // Timestamps for tracking

            // Ensure a student can only enroll in the same subject once
            $table->unique(['student_id', 'subject_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
}
