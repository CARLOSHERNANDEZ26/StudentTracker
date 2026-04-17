<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    /**
     * Show the form to  mark attendance.
     */
   public function create(Request $request)
{
    $date = $request->query('date', now()->format('Y-m-d'));
    $students = Student::all();
    $existingAttendances = Attendance::whereDate('attendance_date', $date)
        ->pluck('status', 'student_id');

    return view('attendances.create', compact('students', 'date', 'existingAttendances'));
}
    /**
     * Store the bulk attendance submission.
     */
    public function store(Request $request)
    {

        $request->validate([
            'attendance_date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*' => 'in:Present,Absent,Late' 
        ]);

        $date = $request->attendance_date;

        foreach ($request->attendances as $student_id => $status) { 
            Attendance::updateOrCreate( 
                [
                    'student_id' => $student_id,
                    'attendance_date' => $date,
                ],
                [
                    'status' => $status
                ]
            );
        }

        return redirect()->route('dashboard')->with('success', 'Attendance recorded successfully!'); 
    }

    public function report()
    {
        $students = Student::with('attendances')->get();
        $reportDate = now()->format('F j, Y');  
        return view('attendances.report', compact('students', 'reportDate'));
    }

}