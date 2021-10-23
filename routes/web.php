<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColisController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\VillesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegionsController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\EnvoiController;
use App\Http\Controllers\RetourController;
use App\Http\Controllers\DemandesController;
use App\Http\Controllers\RetourClientController;
use App\Http\Controllers\FacturesController;
use App\Http\Controllers\RapportsController;

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

Route::get('/', function () {return view('welcome');});
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/Rapports_Bancaires', [RapportsController::class, 'index'])->name('rapports');
Route::post('/NouveauRaport', [RapportsController::class, 'Nouveau'])->name('NouveauRaport');
Route::post('/ImprimerRaport', [RapportsController::class, 'imprimer'])->name('imprimerRaport');

Route::get('/factures', [FacturesController::class, 'index'])->name('factures');
Route::post('/filtreColisFacture', [FacturesController::class, 'filtrer'])->name('filtreColisFacture');
Route::post('/StoreFacture', [FacturesController::class, 'store'])->name('StoreFacture');
Route::post('/imprimerFacture', [FacturesController::class, 'imprimer'])->name('imprimerFacture');
Route::post('/ModifierFacture', [FacturesController::class, 'update'])->name('editFacture');


Route::get('/bons_livraison', [LivraisonController::class, 'index'])->name('bonsLivraion'); 
Route::post('/store', [LivraisonController::class, 'store'])->name('store'); 
Route::post('/imprimer', [LivraisonController::class, 'imprimer'])->name('imprimer'); 
Route::post('/stickers', [LivraisonController::class, 'stickers'])->name('stickers'); 

Route::post('/newEnvoi',[EnvoiController::class, 'newEnvoi'])->name('newEnvoi');
Route::post('/EnvoiCode',[EnvoiController::class, 'store'])->name('EnvoiCode');
Route::get('/valider_envoi', [EnvoiController::class, 'valider'])->name('EnvoiValider');
Route::post('/ValiderCodeEnvoi',[EnvoiController::class, 'ValiderCode'])->name('ValiderCodeEnvoi');
Route::get('/BonsDenvoie', [EnvoiController::class, 'index'])->name('Envoi');
Route::get('/editEnvoi',[EnvoiController::class, 'editEnvoi'])->name('editEnvoi');
Route::post('/RetirerEnvoi',[EnvoiController::class, 'Retirer'])->name('RetirerEnvoi');
Route::post('/imprimerEnvoie', [EnvoiController::class, 'imprimer'])->name('imprimerEnvoie');

Route::post('/newRetourClient',[RetourClientController::class, 'newRetourClient'])->name('newRetourClient');
Route::post('/RetourClientCode',[RetourClientController::class, 'store'])->name('RetourClientCode');
Route::post('/valider_retour_client', [RetourClientController::class, 'valider'])->name('RetourClientValider');
Route::get('/BonsRetourClient', [RetourClientController::class, 'index'])->name('RetourClient');
Route::post('/RetirerRetourClient',[RetourClientController::class, 'Retirer'])->name('RetirerRetourClient');
Route::post('/editRetourClient',[RetourClientController::class, 'editRetourClient'])->name('editRetourClient');


Route::get('/editRetour',[RetourController::class, 'editRetour'])->name('editRetour');
Route::get('/valider_retour', [RetourController::class, 'valider'])->name('RetourValider');
Route::post('/RetourCode',[RetourController::class, 'store'])->name('RetourCode');
Route::post('/ValiderCodeRetour',[RetourController::class, 'ValiderCode'])->name('ValiderCodeRetour');
Route::post('/newRetour',[RetourController::class, 'newRetour'])->name('newRetour');
Route::post('/RetirerRetour',[RetourController::class, 'Retirer'])->name('RetirerRetour');
Route::get('/BonsRetour', [RetourController::class, 'index'])->name('Retour');


Route::get('/colis', [ColisController::class, 'index'])->name('colis');
Route::get('/toutColis', [ColisController::class, 'toutColis'])->name('toutColis');
Route::get('/ColisLivreur', [ColisController::class, 'ColisLivreur'])->name('ColisLivreur');
Route::get('addColis', [ColisController::class, 'create'])->name('newColis');
Route::post('/store-colis', [ColisController::class, 'store'])->name('storeColis');
Route::post('/storeColisStock', [ColisController::class, 'storeColisStock'])->name('storeColisStock');
Route::post('/changer-colis', [ColisController::class, 'ChangerColis'])->name('ChangerColis');
Route::post('/edit-colis', [ColisController::class, 'update'])->name('editColis');
Route::post('/editLivreur', [ColisController::class, 'update_etat'])->name('editLivreur');
Route::post('/addRegion', [RegionsController::class, 'store'])->name('newRegion');

Route::get('/Regions&Villes', [VillesController::class, 'index'])->name('villes');
Route::post('/addVille', [VillesController::class, 'store'])->name('newVille');

Route::get('/stock',[StockController::class, 'index'])->name('stock');
Route::post('/storeStock',[StockController::class, 'store'])->name('storeStock');

Route::post('/add-article',[ArticlesController::class, 'store'])->name('storeArticle');

Route::get('/clients',[UsersController::class, 'clients'])->name('clients');
Route::get('/editCompte',[UsersController::class, 'editCompte'])->name('editCompte');
Route::get('/livreurs',[UsersController::class, 'livreurs'])->name('livreurs');
Route::get('/admins',[UsersController::class, 'admins'])->name('admins');
Route::post('/newLivreur',[UsersController::class, 'newLivreur'])->name('newLivreur');
Route::post('/updateCompte',[UsersController::class, 'updateCompte'])->name('updateCompte');

Route::post('/valider', [ReceptionController::class, 'valider'])->name('receptionValider');
Route::get('/Reception',[ReceptionController::class, 'index'])->name('Reception');
Route::get('/newReception',[ReceptionController::class, 'newReception'])->name('newReception');
Route::post('/ReceptionCode',[ReceptionController::class, 'store'])->name('ReceptionCode');
Route::post('/RetirerReception',[ReceptionController::class, 'Retirer'])->name('RetirerReception');
Route::get('/editReception',[ReceptionController::class, 'editReception'])->name('editReception');


Route::get('/Distribution',[DistributionController::class, 'index'])->name('Distribution');
Route::get('/DistributionLivreur',[DistributionController::class, 'DistributionLivreur'])->name('DistributionLivreur');
Route::post('/Distributeur',[DistributionController::class, 'Distributeur'])->name('Distributeur');
Route::post('/newDistribution',[DistributionController::class, 'newDistribution'])->name('newDistribution');
Route::post('/DistributionCode',[DistributionController::class, 'store'])->name('DistributionCode');
Route::get('/editDistribution',[DistributionController::class, 'editDistribution'])->name('editDistribution');
Route::post('/RetirerDistribution',[DistributionController::class, 'Retirer'])->name('RetirerDistribution');
Route::get('/valider_distribution', [DistributionController::class, 'valider'])->name('DistributionValider');
Route::post('/ValiderCodeDistribution',[DistributionController::class, 'ValiderCode'])->name('ValiderCodeDistribution');
Route::post('/imprimerDistribution', [DistributionController::class, 'imprimer'])->name('imprimerDistribution');


Route::get('/Reclamations',[DemandesController::class, 'Reclamations'])->name('Reclamations');
Route::get('/ChangementRIB',[DemandesController::class, 'ChangementRIB'])->name('ChangementRIB');
Route::get('/ChangementColis',[DemandesController::class, 'ChangementColis'])->name('ChangementColis');
Route::get('/demandesRetour',[DemandesController::class, 'demandesRetour'])->name('demandesRetour');
Route::get('/demandesRamassage',[DemandesController::class, 'demandesRamassage'])->name('demandesRamassage');
Route::post('/newDemande',[DemandesController::class, 'store'])->name('newDemande');
Route::post('/TraiterDemande',[DemandesController::class, 'traiter'])->name('TraiterDemande');
