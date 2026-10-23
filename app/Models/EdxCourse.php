<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdxCourse extends Model
{
    protected $fillable = [
        'edx_id',
        'title',
        'description',
        'code',
        'organization',
        'run',
        'image_url',
        'start_date',
        'end_date',
        'enrollment_url',
        'integrity_url',
        'provider',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'edx_id';
    }
}
