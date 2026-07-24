<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EvenementController as AdminEvenementController;
use App\Http\Controllers\Admin\ProduitController as AdminProduitController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\StagiaireController;
use App\Http\Controllers\Admin\TacheController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StagiairesController;
use App\Http\Controllers\AvisController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Pages publiques
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [HomeController::class, 'about'])->name('about');

Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

Route::get('/actualites', [EvenementController::class, 'index'])->name('evenements.index');
Route::get('/actualites/{evenement}', [EvenementController::class, 'show'])->name('evenements.show');

Route::get('/stagiaire', [StagiairesController::class, 'index'])->name('stagiaire.index');
Route::get('/stagiaires/{stagiaire}', [StagiairesController::class, 'show'])->name('stagiaire.show');

Route::get('/avis', [AvisController::class, 'view'])->name('avis.index');
Route::post('/avis', [AvisController::class, 'store'])->name('avis.store');


Route::get('stagiaire/{stagiaire}/document', [StagiairesController::class, 'showDocument'])->name('stagiaire.document');
Route::get('stagiaire/{stagiaire}/download', [StagiairesController::class, 'downloadDocument'])->name('stagiaire.download');

/*
| Authentification (accessible uniquement aux invités)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
/*
|--------------------------------------------------------------------------
| Back-office (admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('produits', AdminProduitController::class)->except('show');
    Route::resource('services', AdminServiceController::class)->except('show');
    Route::resource('evenements', AdminEvenementController::class)->except('show');
    Route::resource('stagiaires', StagiaireController::class)->except('show');
    Route::resource('taches', TacheController::class)->parameters([
    'taches' => 'tache' // Force l'utilisation de {tache} au lieu de {tach}
])->except('show');
    // Route::resource('taches', TacheController::class)->except('show');
    Route::resource('avi', AvisController::class)->except('show');

    Route::post('search', [StagiaireController::class, 'search'])->name('search');
    Route::get('Stagiaire/{stagiaire}/taches', [TacheController::class, 'view'])->name('taches.view');
    Route::post('tache/{id}/update', [TacheController::class, 'edit'])->name('taches.update');

    Route::get('avi/{avi}', [AvisController::class, 'see'])->name('avi.see');

});

