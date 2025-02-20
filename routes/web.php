<?php

use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EnrollmentController;


// Public Route
Route::get('/', function () {
    return view('welcome');
});

// Admin-Only Routes
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/storage/index', [AdminController::class, 'students'])->name('storage.index');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('subjects', SubjectController::class);
    Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::post('/enroll-student', [EnrollmentController::class, 'enroll'])->name('admin.index');
    Route::get('/enroll-student', [StudentController::class, 'enroll'])->name('admin.index');
    Route::post('/enroll', [EnrollmentController::class, 'enroll']);
    Route::post('/enroll', [EnrollmentController::class, 'enrollStudent']);
    Route::post('/enroll', [EnrollmentController::class, 'enroll']);
    Route::put('/subjects/{id}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::put('/students/{student}/subjects/{subject}/status', [StudentController::class, 'updateEnrollmentStatus'])->name('updateEnrollmentStatus');
    Route::put('/students/{student}/subjects/{subject}/status', [StudentController::class, 'updateEnrollmentStatus'])->name('updateEnrollmentStatus');

    // Ensure only admins can manage students
    Route::resource('students', StudentController::class);
    Route::get('/students/{student}/grades', [GradeController::class, 'show'])
    ->name('students.grades');
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');

    
    // Other resources
    Route::resource('grades', GradeController::class)->except(['show', 'create', 'edit']);
    Route::resource('subjects', SubjectController::class)->except(['show', 'create', 'edit']);
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});

// Logout Route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Profile Routes (Accessible to all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication Routes
require __DIR__.'/auth.php';
