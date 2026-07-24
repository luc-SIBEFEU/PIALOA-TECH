<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvenementController extends Controller
{
    public function index()
    {
        $evenements = Evenement::latest()->paginate(10);

        return view('admin.evenements.index', compact('evenements'));
    }

    public function create()
    {
        $evenement = new Evenement();

        return view('admin.evenements.create', compact('evenement'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('evenements', 'public');
        }
        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('documents', 'public');
        }

        Evenement::create($data);

        return redirect()->route('admin.evenements.index')->with('success', 'Événement ajouté avec succès.');
    }

    public function edit(Evenement $evenement)
    {
        return view('admin.evenements.edit', compact('evenement'));
    }

    public function update(Request $request, Evenement $evenement)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            if ($evenement->image) {
                Storage::disk('public')->delete($evenement->image);
            }
            $data['image'] = $request->file('image')->store('evenements', 'public');
        }

        if ($request->hasFile('document')) {
            if ($evenement->document) {
                Storage::disk('public')->delete($evenement->document);
            }
            $data['document'] = $request->file('document')->store('documents', 'public');
        }

        $evenement->update($data);

        return redirect()->route('admin.evenements.index')->with('success', 'Événement modifié avec succès.');
    }

    public function destroy(Evenement $evenement)
    {
        if ($evenement->image) {
            Storage::disk('public')->delete($evenement->image);
        }
        if ($evenement->document) {
            Storage::disk('public')->delete($evenement->document);
        }

        $evenement->delete();

        return redirect()->route('admin.evenements.index')->with('success', 'Événement supprimé avec succès.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'periode_debut' => ['required', 'date'],
            'periode_fin' => ['nullable', 'date', 'after_or_equal:periode_debut'],
            'image' => ['nullable', 'image', 'max:2048'],
            'document' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ], [
            'nom.required' => "Le nom de l'événement est obligatoire.",
            'description.required' => 'La description est obligatoire.',
            'periode_debut.required' => 'La date de début est obligatoire.',
            'periode_fin.after_or_equal' => 'La date de fin doit être après la date de début.',
            'image.image' => 'Le fichier doit être une image.',
            'document.mimes' => 'Le document doit être un fichier PDF, DOC ou DOCX.',
        ]);
    }
}
