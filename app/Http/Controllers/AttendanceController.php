<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // 1. Show the attendance form
    public function create(Request $request)
    {
        // Get all courses so the teacher can pick one from a dropdown
        $courses = Course::orderBy('course_name')->get();
        
        // Check if the teacher has selected a course from the dropdown yet
        $selectedCourseId = $request->input('course_id');
        $students = collect(); 
        $selectedCourse = null;

        // If a course is selected, fetch ONLY the students enrolled in it
        if ($selectedCourseId) {
            $selectedCourse = Course::with('students')->findOrFail($selectedCourseId);
            $students = $selectedCourse->students;
        }

        return view('attendances.create', compact('courses', 'selectedCourseId', 'selectedCourse', 'students'));
    }

    // 2. Save the attendance to the database
    public function store(Request $request)
    {
        // Validate that a course was selected and date is provided
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'attendance_date' => 'required|date',
            'attendances' => 'required|array', // This will be an array of student_id => status
        ]);

        // Loop through each student's submitted attendance status
        foreach ($request->attendances as $studentId => $status) {
            // updateOrCreate prevents duplicate records for the same student on the same day for the same class!
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'course_id' => $request->course_id,
                    'attendance_date' => $request->attendance_date,
                ],
                [
                    'status' => $status,
                ]
            );
        }

        return redirect()->route('dashboard')->with('success', 'Attendance recorded successfully!');
    }

    public function report(Request $request)
    {
        // Get all courses so the teacher can pick which report to view
        $courses = \App\Models\Course::orderBy('course_name')->get();
        
        $selectedCourseId = $request->input('course_id');
        $reportData = collect();
        $selectedCourse = null;

        if ($selectedCourseId) {
            $selectedCourse = \App\Models\Course::with('students')->findOrFail($selectedCourseId);
            
            // For each student in the class, calculate their total attendance stats
            foreach ($selectedCourse->students as $student) {
                // Get all attendance records for THIS student in THIS class
                $records = \App\Models\Attendance::where('student_id', $student->id)
                    ->where('course_id', $selectedCourseId)
                    ->get();

                // Group and count the statuses
                $reportData->push([
                    'student' => $student,
                    'present_count' => $records->where('status', 'Present')->count(),
                    'late_count' => $records->where('status', 'Late')->count(),
                    'absent_count' => $records->where('status', 'Absent')->count(),
                    'total_classes' => $records->count(),
                ]);
            }
        }

        return view('attendances.report', compact('courses', 'selectedCourseId', 'selectedCourse', 'reportData'));
    }
}