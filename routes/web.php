<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// UPDATED: Route dinamis pakai Route Model Binding
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/events', [DashboardController::class, 'indexEvent'])->name('events.index');
        Route::get('/transactions', [DashboardController::class, 'indexTransaction'])->name('transactions.index');
        Route::resource('events', EventAdminController::class);
        Route::resource('partners', PartnerController::class);
        Route::resource('categories', CategoryController::class)->except(['show']);
    });

});