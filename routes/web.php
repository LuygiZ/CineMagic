<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\ManageUsersController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SeatController;

//Home route
Route::get('/', [MovieController::class, 'indexPoster'])->name('home.show');

//Filmes
// Route::get('movies', [MovieController::class, 'index'])->name('movies.index');
// Route::get('movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
// Route::get('movies/create', [MovieController::class, 'create'])->name('movies.create');
// Route::post('movies', [MovieController::class, 'show'])->name('movies.show');
// Route::put('movies/{movie}', [MovieController::class, 'update'])->name('movies.update');
// Route::delete('movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');

Route::resource('movies', MovieController::class);

//Manage Users
Route::get('manageUsers', [ManageUsersController::class, 'index'])->name('manageUsers.index');
Route::post('manageUsers', [ManageUsersController::class, 'store'])->name('manageUsers.store'); // Corrected this line
Route::get('manageUsers/create', [ManageUsersController::class, 'create'])->name('manageUsers.create');
Route::get('manageUsers/{user}', [ManageUsersController::class, 'show'])->name('manageUsers.show');
Route::get('manageUsers/{user}/edit', [ManageUsersController::class, 'edit'])->name('manageUsers.edit');
Route::put('manageUsers/{user}/update', [ManageUsersController::class, 'update'])->name('manageUsers.update');
Route::delete('manageUsers/{user}', [ManageUsersController::class, 'destroy'])->name('manageUsers.destroy');
Route::post('/user/updateBlocked/{id}', [ManageUsersController::class, 'updateBlocked'])->name('user.updateBlocked');

//Seats
Route::get('seats/{screening}', [SeatController::class, 'index'])->name('seat.index');

//Theaters

//Genres

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
