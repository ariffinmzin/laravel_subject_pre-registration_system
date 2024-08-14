<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Route::get('/lecturers/find', [LecturerController::class, 'find'])->middleware(['auth', 'can:is-admin'])->name('lecturers.find');
Route::get('/find-pak', [StudentController::class, 'findPak'])->middleware(['auth', 'can:is-admin'])->name('find.pak');
Route::get('/students/find', [StudentController::class, 'find'])->middleware(['auth', 'can:is-admin'])->name('students.find');
Route::get('/subjects/find', [SubjectController::class, 'find'])->middleware(['auth', 'can:is-admin'])->name('subjects.find');
Route::post('/subjects/{subject}/status', [SubjectController::class, 'updateStatus'])->middleware(['auth', 'can:is-admin'])->name('subjects.updateStatus');


// 4
Route::middleware(['auth'])->group(function () {

    Route::get('/lecturer-home', function () {     // 2
        return view('lecturers.home');
    })->middleware('can:is-lecturer');

    Route::get('/student-register', function () {
        return view('students.registration');
    })->middleware('can:is-student');

    Route::get('/admin-dashboard', function () {
        return view('administrators.dashboard');
    })->middleware('can:is-admin')->name('admin.dashboard');

    //5
    Route::get('/profile', [ProfileController::class, 'getProfile'])->name('profile.get');
    Route::post('/profile', [ProfileController::class, 'postProfile'])->name('profile.post');

    Route::resource('lecturers', LecturerController::class)->middleware('can:is-admin');

    Route::resource('students', StudentController::class)->middleware('can:is-admin');

    Route::resource('subjects', SubjectController::class)->middleware('can:is-admin');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
