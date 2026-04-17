<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
 protected $fillable = [
        'student_id',
        'attendance_date',
        'status',
    ];

    public function student()
{
    // This links the attendance record back to the student
    return $this->belongsTo(Student::class);
}
}
