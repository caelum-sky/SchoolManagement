<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        if (Schema::hasTable('student_subject')) { // ✅ Prevent error if table doesn't exist
            Schema::table('student_subject', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }

    public function down() {
        Schema::table('student_subject', function (Blueprint $table) {
            $table->string('status')->default('pending'); // ✅ Restore column if rolling back
        });
    }
};
