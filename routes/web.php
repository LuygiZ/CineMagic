<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\ManageUsersController;
use App\Http\Controllers\MovieController;

Route::get('/', [MovieController::class, 'index'])->name('home.show');

//Filmes
Route::get('movies', [App\Http\Controllers\MovieController::class, 'dados'])->name('movies');
Route::get('movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');    
Route::get('movies/create', [MovieController::class, 'create'])->name('movies.create');
Route::post('movies', [MovieController::class, 'store'])->name('movies.store');
Route::put('movies/{movie}', [MovieController::class, 'update'])->name('movies.update');                    
Route::delete('movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');


// REPLACE THESE 7 ROUTES:
// Route::get('courses', [CourseController::class, 'index'])->name('courses.index');
// Route::get('courses/create', [CourseController::class, 'create'])->name('courses.create');
// Route::post('courses', [CourseController::class, 'store'])->name('courses.store');
// Route::get('courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
// Route::put('courses/{course}', [CourseController::class, 'update'])->name('courses.update');
// Route::delete('courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
// Route::get('courses/{course}', [CourseController::class, 'show'])->name('courses.show');
// WITH A SINGLE LINE OF CODE:
//Route::resource('courses', CourseController::class);
//Route::resource('disciplines', DisciplineController::class);

Route::get('manageUsers', [ManageUsersController::class, 'index'])->name('manageUsers.index');
Route::get('manageUsers/{user}', [ManageUsersController::class, 'show'])->name('manageUsers.show');
Route::get('manageUsers/{user}/edit', [ManageUsersController::class, 'edit'])->name('manageUsers.edit');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
