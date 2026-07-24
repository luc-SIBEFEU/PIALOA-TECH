<?php

namespace App\Http\Controllers;

use App\Models\Evenement;

class EvenementController extends Controller
{
    public function index()
    {
        $evenements = Evenement::orderBy('periode_debut', 'desc')->paginate(6);

        return view('evenements.index', compact('evenements'));
    }

    public function show(Evenement $evenement)
    {
        return view('evenements.show', compact('evenement'));
    }
}
