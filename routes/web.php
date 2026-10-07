<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});


Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


Route::middleware('auth')->group(function () {

    // Dashboard — all logged-in users
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');


    // Reservations — all logged-in users
    Route::get('/reservations/available-rooms', [ReservationController::class, 'availableRooms'])
        ->name('reservations.available-rooms');

    Route::resource('reservations', ReservationController::class)
        ->except(['show']);


    // Guests — all logged-in users
    Route::resource('guests', GuestController::class)
        ->except(['show']);


    // Room structure — Admin and Manager only
    Route::middleware('role:admin,manager')->group(function () {

        Route::resource('categories', CategoryController::class)
            ->except(['show']);

        Route::resource('room-types', RoomTypeController::class)
            ->except(['show']);

        Route::resource('rooms', RoomController::class)
            ->except(['show']);

    });


    // User management — Admin and Manager only
    Route::resource('users', UserController::class)
        ->except(['show'])
        ->middleware('role:admin,manager');

});