<?php

use App\Http\Controllers\AlarmController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/jadwal-checkup', [DashboardController::class, 'jadwal'])->name('jadwal');
    Route::get('/jadwal-minum-obat', [DashboardController::class, 'alarm'])->name('alarm');
    Route::get('/data-dokter', [DashboardController::class, 'dokter'])->name('dokter');
    Route::get('/manage-user/{level}', [DashboardController::class, 'user'])->name('user');
    Route::get('/manage-obat', [DashboardController::class, 'obat'])->name('obat');

    // Jadwal Checkup
    Route::post('/store-jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::post('/show-jadwal/{jadwal}', [JadwalController::class, 'show'])->name('jadwal.show');
    Route::post('/edit-jadwal/{jadwal}', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::delete('/delete-jadwal/{jadwal}', [JadwalController::class, 'destroy'])->name('jadwal.delete');


    // User 
    Route::post('/store-user', [UserController::class, 'store'])->name('user.store');
    Route::delete('/delete-user/{user}', [UserController::class, 'destroy'])->name('user.delete');
    Route::post('/show-user/{user}', [UserController::class, 'show'])->name('user.show');    
    Route::post('/edit-user/{user}', [UserController::class, 'edit'])->name('user.edit');    

    // Obat
    Route::post('/store-obat', [ObatController::class, 'store'])->name('obat.store');
    Route::post('/show-obat/{obat}', [ObatController::class, 'show'])->name('obat.show');
    Route::post('/edit-obat/{obat}', [ObatController::class, 'edit'])->name('obat.edit');
    Route::delete('/delete-obat/{obat}', [ObatController::class, 'destroy'])->name('obat.delete');

    // Alarm
    Route::post('/store-alarm', [AlarmController::class, 'store'])->name('alarm.store');
    Route::post('/show-alarm/{alarm}', [AlarmController::class, 'show'])->name('alarm.show');
    Route::post('/edit-alarm/{kd_alarm}', [AlarmController::class, 'edit'])->name('alarm.edit');
    Route::post('/show-time/{kd_alarm}', [AlarmController::class, 'showTime'])->name('alarm.showtime');
    Route::post('/edit-time/{alarm}', [AlarmController::class, 'editTime'])->name('alarm.edittime');
    Route::delete('/delete-alarm/{kd_alarm}', [AlarmController::class, 'destroy'])->name('alarm.delete');

});