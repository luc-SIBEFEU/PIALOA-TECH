<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    public function view()
    {
        $avis = Avis::where('statut','approuvé')->latest()->paginate(9);
        return view('avis.index', compact('avis'));
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Avis::create($validatedData);
        return redirect()->back()->with('success', 'Votre avis a été soumis avec succès !');
    }
    
    public function index(Request $request)
    {
        $avis = Avis::latest()->paginate(10);
        $avis_accepted = Avis::where('statut', 'approuvé')->latest()->paginate(10);
        $avis_added = Avis::where('statut', 'en attente')->latest()->paginate(10);
        $avis_denided = Avis::where('statut', 'rejeté')->latest()->paginate(10);
        return view('admin.avi.index', compact('avis', 'avis_accepted', 'avis_added', 'avis_denided'));
    }
    
public function destroy(Avis $avis)
    {
        try {
            $avis->delete();
            return redirect()->route('admin.avi.index')->with('success', 'Avis supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.avi.index')->with('error', 'Erreur lors de la suppression.');
        }
    }
    
    public function see(Avis $avis)
    {
        return view('admin.avi.see', compact('avis'));
    }
    
    public function cancel(Avis $avis)
    {
        try {
            $avis->update(['statut' => 'rejeté']);
            return redirect()->route('admin.avi.index')->with('success', 'Avis rejeté avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.avi.index')->with('error', 'Erreur lors du rejet de l\'avis.');
        }
    }
    
    public function validate(Avis $avis)
    {
        try {
            $avis->update(['statut' => 'approuvé']);
            return redirect()->route('admin.avi.index')->with('success', 'Avis approuvé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.avi.index')->with('error', 'Erreur lors de l\'approbation de l\'avis.');
        }
    }
}