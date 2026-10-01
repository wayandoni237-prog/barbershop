<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\user\DashboardController;
use App\Http\Controllers\admin\KasirController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\BarberController;
use App\Http\Controllers\admin\AdminreportController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\admin\BookingAdminController;
use App\Http\Controllers\admin\TransactionController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\LaporanController;

Route::get('/', [DashboardController::class, 'index'])->name('user.dashboard');

Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/admindashboard', [AdminDashboardController::class, 'index'])
     ->middleware(['auth', 'role:admin'])
     ->name('admin.dashboard');
// Route::get('/admin/admindashboard', function () {
//     return view('admin.admindashboard');
// })->middleware(['auth']);

Route::middleware(['auth'])->group(function () {
    Route::get('/user/booking', [BookingController::class, 'index'])->name('user.booking');
    Route::post('/user/booking', [BookingController::class, 'store'])->name('user.booking.store');
});


// - - - - CRUD untuk data di table users pada dashboard admin - - - -
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::put('users/{id}/change-password', [UserController::class, 'changePassword'])->name('users.changePassword');


//route CRUD customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');

    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');

    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');

    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');


    
//route CRUD kasir
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');

    Route::get('/kasir/{id}/edit', [KasirController::class, 'edit'])->name('kasir.edit');

    Route::put('/kasir/{id}', [KasirController::class, 'update'])->name('kasir.update');

    Route::delete('/kasir/{id}', [KasirController::class, 'destroy'])->name('kasir.destroy');



//route CRUD service
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');

    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');

    Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');

    Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');

    Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

    Route::patch('/services/{id}', [ServiceController::class, 'active'])->name('services.active');



    //route CRUD Barber
    Route::get('/barbers', [BarberController::class, 'index'])->name('barbers.index');

    Route::get('/barbers/create', [BarberController::class, 'create'])->name('barbers.create');

    Route::post('/barbers', [BarberController::class, 'store'])->name('barbers.store');

    Route::get('/barbers/{id}/edit', [BarberController::class, 'edit'])->name('barbers.edit');

    Route::put('/barbers/{id}', [BarberController::class, 'update'])->name('barbers.update');

    Route::delete('/barbers/{id}', [BarberController::class, 'destroy'])->name('barbers.destroy');

});

// Admin + Kasir — booking saja
Route::middleware(['auth', 'role:admin,kasir'])
    ->prefix('admin')->group(function () {
    Route::get('/bookings',               [BookingAdminController::class, 'index']) ->name('bookings.index');
    Route::patch('/bookings/{id}/accept', [BookingAdminController::class, 'accept'])->name('bookings.accept');
    Route::patch('/bookings/{id}/reject', [BookingAdminController::class, 'reject'])->name('bookings.reject');
    Route::get('/bookings/{id}/edit',     [BookingAdminController::class, 'edit'])  ->name('bookings.edit');    // nanti
    Route::put('/bookings/{id}',  [BookingAdminController::class, 'update'])->name('bookings.update'); // nanti
});

//transaction admin dan kasir
Route::middleware(['auth', 'role:admin,kasir'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/{bookingId}/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/transactions/{bookingId}/store', [TransactionController::class, 'store'])->name('transactions.store');
        Route::post('/transactions/{bookingId}/complete', [TransactionController::class, 'complete'])->name('transactions.complete');
    });

//Laporan customer haroan dan pendapatan bulanan
Route::middleware(['auth', 'role:admin,kasir'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
    });

require __DIR__.'/auth.php';
