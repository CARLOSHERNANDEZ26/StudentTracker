<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Student extends Model
{
    protected $fillable = [
        'student_id',
        'last_name',   
        'first_name',  
        'middle_name', 
        'section',
    ];

    protected function fullFormattedName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => sprintf(
                '%s, %s %s',
                $attributes['last_name'] ?? '',
                $attributes['first_name'] ?? '',
                $attributes['middle_name'] ?? ''
            ),
        );
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Add this right below your attendances() method
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}