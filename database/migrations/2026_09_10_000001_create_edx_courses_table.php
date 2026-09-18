<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('edx_courses', function (Blueprint $table) {
            $table->id();
            $table->string('edx_id')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('code')->nullable();
            $table->string('organization')->nullable();
            $table->string('run')->nullable();
            $table->string('image_url')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('enrollment_url')->nullable();
            $table->string('integrity_url')->nullable();
            $table->string('provider')->default('edX');
            $table->string('status')->default('published');
            $table->timestamps();

            $table->index(['organization', 'code']);
            $table->index('edx_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('edx_courses');
    }
};