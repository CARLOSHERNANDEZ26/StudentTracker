<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;
use App\Models\Student;
use App\Models\Attendance;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $studentCount = Student::count();
    
    $todayRecords = Attendance::with('student')
     ->whereDate('attendance_date', now()->format('Y-m-d'))
     ->whereIn('status', ['Present', 'Late'])
     ->get();

    $presentToday = $todayRecords->where('status', 'Present');
    $lateToday = $todayRecords->where('status', 'Late');

    return view('dashboard', compact('studentCount', 'presentToday', 'lateToday'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('students', StudentController::class);
    Route::get('attendance/mark', [AttendanceController::class, 'create'])->name('attendances.create');
    Route::post('attendance/mark', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('attendance/report', [AttendanceController::class, 'report'])->name('attendances.report');
});

require __DIR__.'/auth.php';
