<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'user_id', 'cover_image', 'status', 'price'];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'enrollments'
        );
    }

    public function materials()
    {
        return $this->hasMany(CourseMaterial::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
