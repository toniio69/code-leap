<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $course_id
 * @property string $title
 * @property string|null $content
 * @property string|null $starter_code
 */
class Lesson extends Model
{
    protected $fillable = ['course_id', 'title', 'content', 'starter_code'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}