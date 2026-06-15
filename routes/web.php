<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\MenuController as ClientMenuController;
use App\Http\Controllers\Client\ReservationController as ClientReservationController;
use App\Http\Controllers\Client\CommandeController as ClientCommandeController;
use App\Http\Controllers\Client\PaiementController as ClientPaiementController;
use App\Http\Controllers\Client\ClientProfilController;

use App\Http\Controllers\Serveur\DashboardController as ServeurDashboardController;
use App\Http\Controllers\Serveur\CommandeController as ServeurCommandeController;
use App\Http\Controllers\Serveur\TableController as ServeurTableController;
use App\Http\Controllers\Serveur\PlanningController;

use App\Http\Controllers\Cuisinier\DashboardController as CuisinierDashboardController;
use App\Http\Controllers\Cuisinier\CommandeController as CuisinierCommandeController;

use App\Http\Controllers\Gerant\DashboardController;
use App\Http\Controllers\Gerant\MenuController;
use App\Http\Controllers\Gerant\CategorieController;
use App\Http\Controllers\Gerant\TableController;
use App\Http\Controllers\Gerant\StatistiqueController;
use App\Http\Controllers\Gerant\ReservationController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\LogController as AdminLogController;
use App\Http\Controllers\Admin\CommandeController as AdminCommandeController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Client\CommandeController;
use App\Http\Controllers\Client\PaiementController;
use App\Http\Controllers\ShwaryWebhookController;
use Illuminate\Support\Facades\Auth;

// ROUTES PUBLIQUES

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// PROFIL
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// AUTHENTIFICATION

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

// ROUTES DASHBOARD PAR RÔLE (DIRECTES)
Route::middleware(['auth'])->group(function () {
    Route::get('/gerant/dashboard', [DashboardController::class, 'index'])->name('gerant.dashboard');
    Route::get('/cuisinier/dashboard', [CuisinierDashboardController::class, 'index'])->name('cuisinier.dashboard');
    Route::get('/serveur/dashboard', [ServeurDashboardController::class, 'index'])->name('serveur.dashboard');
    Route::get('/client/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/handle', [ShwaryWebhookController::class, 'handle'])->name('webhook');
});


// ==========================================
// ROUTES CLIENT - UN SEUL GROUPE
// ==========================================
Route::prefix('client')->middleware(['auth', 'role:client'])->name('client.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');

    // Menu
    Route::get('/menu', [ClientMenuController::class, 'index'])->name('menu');
    Route::get('/menu/search', [ClientMenuController::class, 'search'])->name('menu.search');
    Route::get('/menu/categorie/{slug}', [ClientMenuController::class, 'filtreParCategorie'])->name('menu.categorie');
    Route::get('/menu/{slug}', [ClientMenuController::class, 'show'])->name('menu.show');

    Route::post('/payercom', [PaiementController::class, 'payercom'])->name('payercom');

    // Réservations
    Route::get('/reservations', [ClientReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ClientReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ClientReservationController::class, 'store'])->name('reservations.store');
    Route::post('/reservations/{reservation}/annuler', [ClientReservationController::class, 'annuler'])->name('reservations.annuler');
    Route::get('/disponibilites/check', [ClientReservationController::class, 'checkDisponibilites'])->name('disponibilites.check');
    Route::get('/reservations/{reservation}', [ClientReservationController::class, 'show'])->name('reservations.show');

    // Commandes
    Route::get('/commandes', [ClientCommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/{commande}', [ClientCommandeController::class, 'show'])->name('commandes.show');
    // Dans le groupe client
    Route::post('/commandes/{id}/recuperer', [ClientCommandeController::class, 'confirmerRecuperation'])->name('client.commandes.recuperer');
    // ==========================================
    // PAIEMENT - DANS LE MÊME GROUPE CLIENT
    // ==========================================
    Route::prefix('paiement')->name('paiement.')->group(function () {
        Route::get('/', [ClientPaiementController::class, 'index'])->name('index');
        Route::get('/quick', [ClientPaiementController::class, 'quick'])->name('quick');
        Route::get('/payer/{commande}', [ClientPaiementController::class, 'payer'])->name('payer');
        Route::post('/process/{commande}', [ClientPaiementController::class, 'process'])->name('process');
        Route::get('/success/{commande}', [ClientPaiementController::class, 'success'])->name('success');
        Route::get('/cancel/{commande}', [ClientPaiementController::class, 'cancel'])->name('cancel');
        Route::get('/historique', [ClientPaiementController::class, 'historique'])->name('historique');
    });
});

// ==========================================
// ROUTES PANIER (EN DEHORS DU GROUPE CLIENT)
// ==========================================
Route::prefix('commande')->name('commande.')->group(function () {
    Route::get('/panier', [ClientCommandeController::class, 'panier'])->name('panier');
    Route::post('/ajouter-panier', [ClientCommandeController::class, 'ajouterAuPanier'])->name('ajouter-panier');
    Route::delete('/retirer-panier/{index}', [ClientCommandeController::class, 'retirerDuPanier'])->name('retirer-panier');
    Route::post('/vider-panier', [ClientCommandeController::class, 'viderPanier'])->name('vider-panier');
    Route::post('/passer-commande', [ClientCommandeController::class, 'passerCommande'])->name('passer');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/panier', [ClientCommandeController::class, 'panier'])->name('commande.panier');
    // Assurez-vous que cette route existe
    // Assurez-vous que cette route existe
    Route::post('/ajouter-panier', [App\Http\Controllers\Client\CommandeController::class, 'ajouterAuPanier'])->name('ajouter-panier');
    Route::get('/panier-count', [ClientCommandeController::class, 'getPanierCount'])->name('commande.panier.count');
    Route::delete('/retirer-panier/{id}', [ClientCommandeController::class, 'retirerDuPanier'])->name('commande.retirer-panier');
    Route::post('/vider-panier', [ClientCommandeController::class, 'viderPanier'])->name('commande.vider-panier');
    Route::post('/valider-commande', [ClientCommandeController::class, 'passerCommande'])->name('commande.valider');
    Route::get('/panier-count', [App\Http\Controllers\Client\CommandeController::class, 'getPanierCount'])->name('panier.count');
    route::get('/form_payement/{idcommande}', [ClientPaiementController::class, 'form_payement'])->name('form_payement');

    // Route pour annuler une commande
    Route::post('/client/commandes/{commande}/annuler', [ClientCommandeController::class, 'annuler'])->name('client.commandes.annuler');

    // ==========================================
    // ROUTES CART
    // ==========================================
    Route::middleware(['auth'])->prefix('cart')->name('cart.')->group(function () {
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::get('/count', [CartController::class, 'count'])->name('count');
        Route::get('/items', [CartController::class, 'items'])->name('items');
        Route::post('/update', [CartController::class, 'update'])->name('update');
        Route::post('/remove', [CartController::class, 'remove'])->name('remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/profil', [ClientProfilController::class, 'index'])->name('profil');
        Route::post('/profil/update', [ClientProfilController::class, 'update'])->name('profil.update');
        // Ajoutez cette route
        Route::post('/update-panier', [App\Http\Controllers\Client\CommandeController::class, 'updateQuantite'])->name('update.panier');

        // ==========================================
        // ROUTE CALLBACK SHWARY (SANS AUTH)
        // ==========================================
        Route::post('/api/paiement/callback', [ClientPaiementController::class, 'callback'])->name('api.paiement.callback');
    });





    // ==========================================
    // ROUTES SERVEUR - CORRIGÉES
    // ==========================================
    Route::middleware(['auth'])->prefix('serveur')->name('serveur.')->group(function () {

        // Dashboard Serveur
        Route::get('/dashboard', [ServeurDashboardController::class, 'index'])->name('dashboard');

        // Commandes Serveur
        Route::get('/commandes', [ServeurCommandeController::class, 'index'])->name('commandes.index');
        Route::get('/commandes/create', [ServeurCommandeController::class, 'create'])->name('commandes.create');
        Route::post('/commandes', [ServeurCommandeController::class, 'store'])->name('commandes.store');
        Route::get('/commandes/{commande}', [ServeurCommandeController::class, 'show'])->name('commandes.show');
        Route::post('/commandes/{commande}/valider', [ServeurCommandeController::class, 'valider'])->name('commandes.valider');
        Route::post('/commandes/{commande}/envoyer-cuisine', [ServeurCommandeController::class, 'envoyerCuisine'])->name('commandes.envoyer-cuisine');
        Route::get('/commandes/{commande}/addition', [ServeurCommandeController::class, 'addition'])->name('commandes.addition');
        Route::post('/commandes/{commande}/servir', [ServeurCommandeController::class, 'servir'])->name('commandes.servir');
        Route::get('/commandes/{commande}/addition', [ServeurCommandeController::class, 'addition'])->name('commandes.addition');

        // Tables Serveur
        Route::get('/tables', [ServeurTableController::class, 'index'])->name('tables.index');
        Route::post('/tables/{table}/changer-statut', [ServeurTableController::class, 'changerStatut'])->name('tables.changer-statut');

        // Planning Serveur
        Route::get('/planning', [PlanningController::class, 'index'])->name('planning.index');



        // ==========================================
        // PAIEMENT SERVEUR (DANS LE GROUPE)
        // ==========================================
        Route::prefix('paiement')->name('paiement.')->group(function () {
            Route::get('/', [App\Http\Controllers\Serveur\PaiementController::class, 'index'])->name('index');
            Route::get('/{commande}', [App\Http\Controllers\Serveur\PaiementController::class, 'show'])->name('show');
            Route::post('/process/{commande}', [App\Http\Controllers\Serveur\PaiementController::class, 'process'])->name('process');
            Route::post('/confirmer/{paiement}', [App\Http\Controllers\Serveur\PaiementController::class, 'confirmerPaiementEnLigne'])->name('confirmer');
            Route::get('/recu/{commande}', [App\Http\Controllers\Serveur\PaiementController::class, 'recu'])->name('recu');
            Route::get('/download/{commande}', [App\Http\Controllers\Serveur\PaiementController::class, 'downloadRecu'])->name('download');
            // Vérification des nouveaux paiements (AJAX)
            Route::get('/serveur/paiement/check-new', function () {
                $count = App\Models\Paiement::where('statut', 'valide')
                    ->whereIn('mode_paiement', ['shwary', 'airtel_money', 'orange_money'])
                    ->whereNull('encaisse_par')
                    ->count();
                return response()->json(['new_payments' => $count]);
            })->middleware('auth')->name('serveur.paiement.check');
        });
    });
});

// ==========================================
// ROUTES CUISINIER - CORRIGÉES
// ==========================================
Route::prefix('cuisinier')->middleware(['auth', 'role:cuisinier'])->name('cuisinier.')->group(function () {
    Route::get('/dashboard', [CuisinierDashboardController::class, 'index'])->name('dashboard');
    Route::get('/commandes', [CuisinierCommandeController::class, 'index'])->name('commandes');
    Route::post('/commandes/{commande}/demarrer', [CuisinierCommandeController::class, 'demarrerPreparation'])->name('commandes.demarrer');
    Route::post('/commandes/{commande}/pret', [CuisinierCommandeController::class, 'marquerPret'])->name('commandes.pret');
    Route::get('/commandes/{commande}', [CuisinierCommandeController::class, 'show'])->name('commandes.show');
});

// ==========================================
// ROUTES GERANT
// ==========================================
Route::prefix('gerant')->middleware(['auth', 'role:gerant'])->name('gerant.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('menu', MenuController::class);
    Route::resource('categories', CategorieController::class);
    Route::resource('tables', TableController::class);
    Route::get('/statistiques', [StatistiqueController::class, 'index'])->name('statistiques');
    Route::get('/statistiques/export', [StatistiqueController::class, 'export'])->name('statistiques.export');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations');
    Route::post('/reservations/{reservation}/annuler', [ReservationController::class, 'annuler'])->name('reservations.annuler');
    // routes/web.php - Ajoutez cette ligne dans le groupe des routes gerant

    Route::post('menu/{menu}/toggle', [MenuController::class, 'toggleDisponible'])
        ->name('menu.toggle');
});

// TABLES
// ✅ ROUTE TOGGLE (IMPORTANT)
Route::post('/tables/{table}/toggle', [TableController::class, 'toggleActive'])
    ->name('tables.toggle');



// ==========================================
// ROUTES ADMIN
// ==========================================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::post('/users/{user}/toggle', [AdminUserController::class, 'toggleActif'])->name('users.toggle');
    Route::resource('roles', AdminRoleController::class);
    Route::get('/logs', [AdminLogController::class, 'index'])->name('logs');
    Route::get('/logs/download', [AdminLogController::class, 'download'])->name('logs.download');
    Route::delete('/logs/clear', [AdminLogController::class, 'clear'])->name('logs.clear');

    // Commandes admin
    Route::get('/commandes', [AdminCommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/{commande}', [AdminCommandeController::class, 'show'])->name('commandes.show');
});

// Dans routes/web.php
Route::post('/api/paiement/callback', [App\Http\Controllers\Client\PaiementController::class, 'callback'])->name('api.paiement.callback');
