<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScreeningController;

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
//Route::get('users', [UserController::class, 'index'])->name('users.index');
//Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
//Route::get('users/create', [UserController::class, 'create'])->name('users.create');
//Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
//Route::put('users/{user}/update', [UserController::class, 'update'])->name('users.update');
//Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::resource('users', UserController::class);
Route::post('users', [UserController::class, 'store'])->name('users.store');
Route::post('/user/updateBlocked/{id}', [UserController::class, 'updateBlocked'])->name('user.updateBlocked');
Route::delete('users/{user}/photo', [UserController::class, 'destroyPhoto'])->name('users.photo.destroy');
Route::put('users/{user}/updatePhoto', [UserController::class, 'updatePhoto'])->name('users.updatePhoto');

//Screenings
Route::get('screenings', [ScreeningController::class, 'index'])->name('screenings.index');
Route::get('screenings/{screening}/edit', [ScreeningController::class, 'edit'])->name('screenings.edit');
Route::get('screenings/create', [ScreeningController::class, 'create'])->name('screenings.create');
Route::put('screenings/{screening}/update', [ScreeningController::class, 'update'])->name('screenings.update');
Route::delete('screenings/{screening}', [ScreeningController::class, 'destroy'])->name('screenings.destroy');

Route::post('screenings', [ScreeningController::class, 'store'])->name('screenings.store');
Route::get('screenings/{screening}/control', [ScreeningController::class, 'control'])->name('screenings.control');
Route::get('screenings/ticket/{ticketCode}/verify', [ScreeningController::class, 'verifyTicket'])->name('screenings.verifyTicket');
Route::post('screenings/{screening}/control/enableControl', [ScreeningController::class, 'enableControl'])->name('screenings.enableControl');
Route::post('screenings/{screening}/control/disableControl', [ScreeningController::class, 'disableControl'])->name('screenings.disableControl');

Route::get('screenings/seats/{screening}', [ScreeningController::class, 'seats'])->name('screenings.seats');

//Theaters

//Genres

//Pdf
Route::get('generatePdf', [PdfController::class, 'generatePdf']);

//Cart
Route::get('cart', [CartController::class, 'show'])->name('cart.show');
Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('cart/confirm', [CartController::class, 'confirm'])->name('cart.confirm');
Route::delete('cart/remove/{ticket}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');

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
