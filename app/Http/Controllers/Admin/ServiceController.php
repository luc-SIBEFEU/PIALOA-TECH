<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $service = new Service();

        return view('admin.services.create', compact('service'));
    }

    public function store(Request $request)
    {
        Service::create($this->validateData($request));

        return redirect()->route('admin.services.index')->with('success', 'Service ajouté avec succès.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $service->update($this->validateData($request));

        return redirect()->route('admin.services.index')->with('success', 'Service modifié avec succès.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service supprimé avec succès.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icone' => ['nullable', 'string', 'max:100'],
        ], [
            'nom.required' => 'Le nom du service est obligatoire.',
            'description.required' => 'La description est obligatoire.',
        ]);
    }
}
