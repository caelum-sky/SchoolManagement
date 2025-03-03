<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('student_subject', function (Blueprint $table) {
            $table->string('status')->default('Enrolled')->after('subject_id');
        });
    }

    public function down()
    {
        Schema::table('student_subject', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
