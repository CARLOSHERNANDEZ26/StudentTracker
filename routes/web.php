<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseController; 
use Illuminate\Support\Facades\Route;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Course; 
use App\Http\Controllers\AttendanceReviewController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $studentCount = Student::count();
    $courses = Course::withCount('students')->get(); 

    $todayRecords = Attendance::with(['student', 'course'])
    ->whereHas('course')
     ->whereDate('attendance_date', now()->format('Y-m-d'))
     ->get();

    $attendancesByCourse = $todayRecords->groupBy('course_id');

    return view('dashboard', compact('studentCount', 'courses', 'attendancesByCourse'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::resource('courses', CourseController::class);
    Route::resource('students', StudentController::class);
    Route::get('attendance/mark', [AttendanceController::class, 'create'])->name('attendances.create');
    Route::post('attendance/mark', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('attendance/report', [AttendanceController::class, 'report'])->name('attendances.report');
    Route::get('attendance/review/{course}', [AttendanceReviewController::class, 'show'])->name('attendances.review');
    Route::post('attendance/review/{course}', [AttendanceReviewController::class, 'update'])->name('attendances.review.update');
});

require __DIR__.'/auth.php';