<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\Produit;
use App\Models\Service;
use App\Models\Stagiaire;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::latest()->take(6)->get();
        $produits = Produit::latest()->take(3)->get();
        $stagiaires = Stagiaire::latest()->take(4)->get();
        $evenements = Evenement::orderBy('periode_debut', 'desc')->take(3)->get();

        return view('home', compact('services', 'produits', 'evenements', 'stagiaires'));
    }

    public function about()
    {
        return view('about');
    }
}
