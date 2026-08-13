<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EducationSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_required_tables_and_columns_exist(): void
    {
        $this->assertTrue(Schema::hasTable('users'));
        $this->assertTrue(Schema::hasColumn('users', 'role'));

        $this->assertTrue(Schema::hasTable('courses'));
        $this->assertTrue(Schema::hasColumns('courses', ['title', 'description', 'user_id', 'cover_image', 'status']));

        $this->assertTrue(Schema::hasTable('course_user'));
        $this->assertTrue(Schema::hasColumns('course_user', ['user_id', 'course_id', 'status']));

        $this->assertTrue(Schema::hasTable('course_materials'));
        $this->assertTrue(Schema::hasColumns('course_materials', ['course_id', 'title', 'file_path', 'file_type', 'is_preview']));
    }
}
