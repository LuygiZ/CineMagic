<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StatisticController;

//Home route
Route::get('/', [MovieController::class, 'indexPoster'])->name('home.show');

//Autentication Required
Route::middleware(['auth', 'verified'])->group(function () {

    //Purchases
    Route::get('purchases', [PurchaseController::class, 'index'])->name('purchases.show');

    //Pdf
    Route::get('pdf/download', [PdfController::class, 'downloadPdf'])->name('pdf.download');

    //Cart
    Route::get('cart/purchase', [CartController::class, 'buy'])->name('cart.buy');
    Route::post('cart/purchase', [CartController::class, 'store'])->name('cart.store');

    //Users
    Route::delete('users/{user}/photo', [UserController::class, 'destroyPhoto'])->name('users.photo.destroy');

    //----------------------------
    // NEED ADMIN OR EMPLOYEE ROLE
    //----------------------------

    Route::middleware('can:employeeOrAdmin')->group(function () {

        //Theater
        Route::resource('theater', TheaterController::class);
        Route::delete('theater/{theater}/photo', [TheaterController::class, 'destroyPhoto'])->name('theater.photo.destroy');

        //Movies
        Route::resource('movies', MovieController::class);
        Route::delete('movies/{movie}/photo', [MovieController::class, 'destroyPhoto'])->name('movies.photo.destroy');

        //Genres
        Route::resource('genre', GenreController::class);

        //Sreenings
        Route::resource('screenings', ScreeningController::class);
        Route::get('screenings/{screening}/control', [ScreeningController::class, 'control'])->name('screenings.control');
        Route::get('screenings/ticket/verify', [ScreeningController::class, 'verifyTicket'])->name('screenings.verifyTicket');
        Route::post('screenings/{screening}/control', [ScreeningController::class, 'changeControl'])->name('screenings.changeControl');
        Route::post('screenings/{screening}/ticket/{ticket}/accept', [ScreeningController::class, 'acceptTicket'])->name('screenings.acceptTicket');

    });

    //----------------------------
    // NEED ADMIN ROLE
    //----------------------------

    Route::middleware('can:admin')->group(function () {

        //Users
        Route::resource('users', UserController::class);
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::post('/user/updateBlocked/{id}', [UserController::class, 'updateBlocked'])->name('user.updateBlocked');

        //Statistics
        Route::get('statistics', [StatisticController::class, 'index'])->name('statistics.show');

        //Configurations
        Route::get('configurations/edit', [ConfigurationController::class, 'edit'])->name('configurations.edit');
        Route::get('configurations', [ConfigurationController::class, 'index'])->name('configurations.index');
        Route::put('configurations', [ConfigurationController::class, 'update'])->name('configurations.update');
    });

});

//Autentication Not Required
    //Movies
    Route::resource('movies', MovieController::class)->only(['show']);

    //Seats
    Route::get('screenings/seats/{screening}', [ScreeningController::class, 'seats'])->name('screenings.seats');

    //Cart
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');
    Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
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


require __DIR__.'/auth.php';
