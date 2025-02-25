<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->decimal('grade', 3, 2)->change();
        });
    }
    
    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->integer('grade')->change();
        });
    }
    
};
