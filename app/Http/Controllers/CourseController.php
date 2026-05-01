<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Show the form to create a new class
    public function create()
    {
        return view('courses.create');
    }

    // Save the new class to the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:20|unique:courses',
            'course_name' => 'required|string|max:255',
            'days' => 'required|array|min:1', // Ensures at least one day is selected
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // 1. Combine the array of days into a single string (e.g., ['M', 'W'] becomes "MW")
        $schedule_days = implode('', $request->days);

        // 2. Format the times to 12-hour AM/PM and combine them
        $startFormatted = \Carbon\Carbon::parse($request->start_time)->format('h:i A');
        $endFormatted = \Carbon\Carbon::parse($request->end_time)->format('h:i A');
        $schedule_time = $startFormatted . ' - ' . $endFormatted;

        // 3. Save to database using the combined strings
        Course::create([
            'course_code' => $validated['course_code'],
            'course_name' => $validated['course_name'],
            'schedule_days' => $schedule_days,
            'schedule_time' => $schedule_time,
        ]);

        return redirect()->route('dashboard')->with('success', 'Class created successfully!');
    }

    // This will handle the "Manage Class" link later
  public function show(Course $course)
{
    // Load existing students in this course
    $course->load('students');

    // Get students NOT currently enrolled in this class for the "Enroll" dropdown
    $availableStudents = \App\Models\Student::whereDoesntHave('courses', function($query) use ($course) {
        $query->where('courses.id', $course->id);
    })->get();

    return view('courses.show', compact('course', 'availableStudents'));
}

// Add this new method to handle the enrollment logic
public function enroll(Request $request, Course $course)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
    ]);

    // This "attaches" the student to the course in the pivot table
    $course->students()->attach($request->student_id);

    return back()->with('success', 'Student enrolled successfully!');
}
}