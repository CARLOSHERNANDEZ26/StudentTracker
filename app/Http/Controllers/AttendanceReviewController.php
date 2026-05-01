<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceReviewController extends Controller
{
    // 1. Show the attendance records for a specific class (defaults to today)
    public function show(Course $course)
    {
        $date = now()->format('Y-m-d'); // Keep it simple: review today's attendance

        $attendances = Attendance::with('student')
            ->where('course_id', $course->id)
            ->whereDate('attendance_date', $date)
            ->get();

        // If a teacher clicks "Review" but hasn't taken attendance yet today
        if ($attendances->isEmpty()) {
            return redirect()->route('attendances.create')
                ->with('error', 'No attendance recorded for this class today. Please record it first.');
        }

        return view('attendances.review', compact('course', 'attendances', 'date'));
    }

    // 2. Save the edited attendance records
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'attendances' => 'required|array',
            'date' => 'required|date'
        ]);

        // Loop through the submitted edits and update the database
        foreach ($request->attendances as $attendanceId => $status) {
            Attendance::where('id', $attendanceId)->update(['status' => $status]);
        }

        return redirect()->route('dashboard')->with('success', 'Attendance records updated successfully!');
    }
}