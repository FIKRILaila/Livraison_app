<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColisController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/colis', [App\Http\Controllers\ColisController::class, 'index'])->name('colis');
Route::get('addColis', [ColisController::class, 'create'])->name('newColis');
Route::post('/store-colis', [App\Http\Controllers\ColisController::class, 'store'])->name('storeColis');
