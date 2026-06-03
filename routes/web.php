<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PartnerController; 
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{id}', [EventController::class,'show'])->name('events.show');
Route::get('/checkout', [EventController::class,'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');
Route::post('/logout', function() { return redirect('/'); })->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/events', [DashboardController::class,'indexEvent'])->name('events.index');
    Route::get('/transactions', [DashboardController::class,'indexTransaction'])->name('transactions.index');
    Route::resource('events', EventAdminController::class);
    Route::resource('partners', PartnerController::class);
    Route::resource('categories', CategoryController::class)->except(['show']);
});