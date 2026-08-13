<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $course_id
 * @property string $title
 * @property string $file_path
 * @property string|null $file_type
 * @property bool $is_preview
 */
class CourseMaterial extends Model
{
    protected $table = 'course_materials';

    protected $fillable = ['course_id', 'title', 'file_path', 'file_type', 'is_preview'];

    protected $casts = [
        'is_preview' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
