<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student; // <-- Don't forget this import!

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index()
    {
     
        $students = \App\Models\Student::orderBy('created_at', 'desc')->paginate(15);

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
{
    // This tells Laravel exactly what rules the data must follow
    $validated = $request->validate([
        'student_id' => 'required|string|max:9|unique:students,student_id', 
        'last_name' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255', 
        'section' => 'required|string|max:50',
    ], [
        'student_id.max' => 'The Student ID cannot be more than 9 characters long.',
        'student_id.unique' => 'This Student ID is already registered in the system.',
    ]);

    Student::create($validated);

    return redirect()->route('students.index')->with('success', 'Student added successfully!');
}

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
    'student_id' => 'required|string|max:255|unique:students,student_id,' . ($student->id ?? 'NULL'),
    'last_name' => 'required|string|max:255',
    'first_name' => 'required|string|max:255',
    'middle_name' => 'nullable|string|max:255',
    'section' => 'required|string|max:255',
]);
        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}