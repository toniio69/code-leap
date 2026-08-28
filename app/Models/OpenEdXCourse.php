<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenEdXCourse extends Model
{
    protected $fillable = [
        'title',
        'description',
        'course_id',
        'org',
        'run',
        'image_url',
        'start_date',
        'end_date',
        'enrollment_url',
        'integrity_url',
    ];
}