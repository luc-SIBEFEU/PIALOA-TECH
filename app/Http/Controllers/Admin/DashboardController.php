<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use App\Models\Produit;
use App\Models\Service;
use App\Models\Stagiaire;
use App\Models\Avis;
use App\Models\Tache;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'produits' => Produit::count(),
            'services' => Service::count(),
            'evenements' => Evenement::count(),
            'stagiaires' => Stagiaire::count(),
            'avis' => Avis::where('statut','en attente')->count(),
            'taches' => Tache::count(),
        ];

        $derniersEvenements = Evenement::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'derniersEvenements'));
    }
}
