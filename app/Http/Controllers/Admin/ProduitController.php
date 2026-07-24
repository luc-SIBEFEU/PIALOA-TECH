<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::latest()->paginate(10);

        return view('admin.produits.index', compact('produits'));
    }

    public function create()
    {
        $produit = new Produit();

        return view('admin.produits.create', compact('produit'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        Produit::create($data);

        return redirect()->route('admin.produits.index')->with('success', 'Produit ajouté avec succès.');
    }

    public function edit(Produit $produit)
    {
        return view('admin.produits.edit', compact('produit'));
    }

    public function update(Request $request, Produit $produit)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit->update($data);

        return redirect()->route('admin.produits.index')->with('success', 'Produit modifié avec succès.');
    }

    public function destroy(Produit $produit)
    {
        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }

        $produit->delete();

        return redirect()->route('admin.produits.index')->with('success', 'Produit supprimé avec succès.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'site_web' => ['nullable', 'url', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ], [
            'nom.required' => 'Le nom du produit est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'site_web.url' => "Le site web doit être une URL valide (ex : https://...).",
            'image.image' => "Le fichier doit être une image.",
            'image.max' => "L'image ne doit pas dépasser 2 Mo.",
        ]);
    }
}
