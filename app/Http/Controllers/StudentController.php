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
     
        $students = Student::all();
        
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
        $validated = $request->validate([
    'student_id' => 'required|string|max:255|unique:students,student_id,' . ($student->id ?? 'NULL'),
    'last_name' => 'required|string|max:255',
    'first_name' => 'required|string|max:255',
    'middle_name' => 'nullable|string|max:255', // Middle name is often optional
    'section' => 'required|string|max:255',
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