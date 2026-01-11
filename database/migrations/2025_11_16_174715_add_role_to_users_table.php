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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'teacher', 'student'])->default('student')->after('email');
            $table->string('phone')->nullable()->after('role');
            $table->string('class')->nullable()->after('phone');
            $table->string('student_id')->nullable()->unique()->after('class');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'class', 'student_id']);
        });
    }
};
