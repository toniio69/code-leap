<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('id');
            $table->string('language')->nullable()->after('slug');
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->nullable()->after('language');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['slug', 'language', 'level']);
        });
    }
};