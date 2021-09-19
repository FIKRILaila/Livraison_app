<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColisController;
use App\Http\Controllers\BonsController;
use App\Http\Controllers\VillesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegionsController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ArticlesController;

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



Route::get('/factures', function () {
    return view('factures');
})->name('factures');

Route::get('/ramassage', function () {
    return view('ramassage');
})->name('ramassage');



Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/retour',[HomeController::class, 'retour'])->name('retour');
Route::post('/store', [BonsController::class, 'store'])->name('store'); //test
Route::get('/colis', [ColisController::class, 'index'])->name('colis');
Route::get('/Regions&Villes', [VillesController::class, 'index'])->name('villes');
Route::get('addColis', [ColisController::class, 'create'])->name('newColis');
Route::post('/addRegion', [RegionsController::class, 'store'])->name('newRegion');
Route::post('/addVille', [VillesController::class, 'store'])->name('newVille');
Route::post('/store-colis', [ColisController::class, 'store'])->name('storeColis');
Route::get('/stock',[StockController::class, 'index'])->name('stock');
Route::get('/nouveauStock',[StockController::class, 'create'])->name('nouveauStock');
Route::post('/storeStock',[StockController::class, 'store'])->name('storeStock');
Route::get('/article',[ArticlesController::class, 'create'])->name('article');
Route::post('/add-article',[ArticlesController::class, 'store'])->name('storeArticle');

Route::get('/refuses',[HomeController::class, 'refuser'])->name('refuses');