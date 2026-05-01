<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // 1. Allow these fields to be saved to the database
    protected $fillable = [
        'course_code',
        'course_name',
        'schedule_days',
        'schedule_time',
    ];

    // 2. The Many-to-Many Relationship
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}