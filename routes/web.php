<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PresentController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::group(['middleware' => 'is_admin'], function(){
        Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
        Route::get('/kehadiran', [PresentController::class, 'index'])->name('kehadiran.index');
    });
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/daftar-hadir', [PresentController::class, 'show'])->name('daftar-hadir');
    Route::patch('/absen/{kehadiran}', [PresentController::class, 'checkOut'])->name('kehadiran.check-out');
    Route::post('/absen', [PresentController::class, 'checkIn'])->name('kehadiran.check-in');
});