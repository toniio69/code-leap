<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property string|null $description
 * @property int|null $user_id
 * @property string|null $cover_image
 * @property string|null $status
 * @property float $price
 * @property string|null $language
 * @property string|null $level
 * @property-read Pivot $pivot
 */
class Course extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'user_id', 'cover_image', 'status', 'price', 'language', 'level'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsToMany<User, $this, Pivot, 'pivot'>
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'enrollments'
        );
    }

    /**
     * @return HasMany<CourseMaterial, $this>
     */
    public function materials(): HasMany
    {
        return $this->hasMany(CourseMaterial::class);
    }

    /**
     * @return HasMany<Payment, $this>
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * @return HasMany<Lesson, $this>
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}
