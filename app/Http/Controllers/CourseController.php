<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function create()
    {
        return view('courses.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:20|unique:courses',
            'course_name' => 'required|string|max:255',
            'days' => 'required|array|min:1', 
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $schedule_days = implode('', $request->days); 

        $startFormatted = \Carbon\Carbon::parse($request->start_time)->format('h:i A');
        $endFormatted = \Carbon\Carbon::parse($request->end_time)->format('h:i A');
        $schedule_time = $startFormatted . ' - ' . $endFormatted;


        Course::create([
            'course_code' => $validated['course_code'],
            'course_name' => $validated['course_name'],
            'schedule_days' => $schedule_days,
            'schedule_time' => $schedule_time,
        ]);

        return redirect()->route('dashboard')->with('success', 'Class created successfully!');
    }

public function show(Course $course)
    {
        $availableStudents = \App\Models\Student::whereNotIn('id', $course->students->pluck('id'))->orderBy('last_name')->get();
        $todaysAttendance = \App\Models\Attendance::where('course_id', $course->id)
            ->whereDate('attendance_date', now()->format('Y-m-d'))
            ->pluck('status', 'student_id');

        return view('courses.show', compact('course', 'availableStudents', 'todaysAttendance'));
    }


public function enroll(Request $request, Course $course)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
    ]);

    $course->students()->attach($request->student_id);

    return back()->with('success', 'Student enrolled successfully!');
}
public function unenroll(Course $course, Student $student)
{
    // This is the magic line that removes the connection in the pivot table
    $course->students()->detach($student->id);

    return redirect()->route('courses.show', $course->id)
        ->with('success', 'Student has been removed from the class roster.');
}

}