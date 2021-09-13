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

Route::get('/stock', function () {
    return view('stock');
})->name('stock');

Route::get('/factures', function () {
    return view('factures');
})->name('factures');

Route::get('/ramassage', function () {
    return view('ramassage');
})->name('ramassage');

Route::get('/article', function () {
    return view('article');
})->name('article');

Route::get('/nouveauStock', function () {
    return view('nouveauStock');
})->name('nouveauStock');

Route::get('/refuses', function () {
    return view('refuses');
})->name('refuses');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/retour',[HomeController::class, 'retour'])->name('retour');
Route::post('/store', [HomeController::class, 'store'])->name('store'); //test
Route::get('/colis', [ColisController::class, 'index'])->name('colis');
Route::get('/Regions&Villes', [VillesController::class, 'index'])->name('villes');
Route::get('addColis', [ColisController::class, 'create'])->name('newColis');
Route::post('/addRegion', [RegionsController::class, 'store'])->name('newRegion');
Route::post('/addVille', [VillesController::class, 'store'])->name('newVille');
Route::post('/store-colis', [ColisController::class, 'store'])->name('storeColis');
 