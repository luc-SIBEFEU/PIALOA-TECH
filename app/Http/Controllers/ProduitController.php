<?php

namespace App\Http\Controllers;

use App\Models\Produit;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::latest()->paginate(9);

        return view('produits.index', compact('produits'));
    }
}
