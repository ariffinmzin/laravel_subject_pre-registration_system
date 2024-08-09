<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LecturerController;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Route::get('/lecturers/find', [LecturerController::class, 'find'])->name('lecturers.find');

// 4
Route::middleware(['auth'])->group(function(){   
    
    Route::get('/lecturer-home', function(){     // 2
        return view('lecturers.home');
    })->middleware('can:is-lecturer');
    
    Route::get('/student-register', function(){
        return view('students.registration');
    })->middleware('can:is-student');

    Route::get('/admin-dashboard', function(){
        return view('administrators.dashboard');
    })->middleware('can:is-admin')->name('admin.dashboard');

    //5
    Route::get('/profile',[ProfileController::class, 'getProfile'])->name('profile.get');
    Route::post('/profile', [ProfileController::class, 'postProfile'])->name('profile.post');

    Route::resource('lecturers',LecturerController::class)->middleware('can:is-admin');
    
    

    

});





Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


