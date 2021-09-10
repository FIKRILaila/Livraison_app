<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColisController;
use App\Http\Controllers\VillesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegionsController;

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

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/colis', [ColisController::class, 'index'])->name('colis');
Route::get('/Regions&Villes', [VillesController::class, 'index'])->name('villes');
Route::get('addColis', [ColisController::class, 'create'])->name('newColis');
Route::post('/addRegion', [RegionsController::class, 'store'])->name('newRegion');
Route::post('/addVille', [VillesController::class, 'store'])->name('newVille');
Route::post('/store-colis', [ColisController::class, 'store'])->name('storeColis');
