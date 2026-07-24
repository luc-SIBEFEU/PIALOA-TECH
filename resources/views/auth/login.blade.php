@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <section class="max-w-md mx-auto px-6 py-24">
        <div class="text-center mb-10">
            <span class="dot-cluster mx-auto mb-4" style="display:inline-grid"><span></span><span></span><span></span><span></span><span></span><span></span></span>
            <h1 class="text-3xl font-bold">Espace administration</h1>
            <p class="text-slate text-sm mt-2">Connectez-vous pour accéder au tableau de bord.</p>
        </div>

        <form method="POST" action="{{ route('login.attempt') }}" class="card space-y-5">
            @csrf

            <div>
                <label for="email" class="label-field">Adresse e-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus class="input-field @error('email') !border-claret @enderror">
                @error('email')
                    <p class="text-claret text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="label-field">Mot de passe</label>
                <input type="password" name="password" id="password" required class="input-field @error('password') !border-claret @enderror">
                @error('password')
                    <p class="text-claret text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-slate">
                <input type="checkbox" name="remember" class="rounded border-slate/40 text-ember focus:ring-ember">
                Se souvenir de moi
            </label>

            <button type="submit" class="btn-primary w-full justify-center">Se connecter</button>
        </form>
    </section>
@endsection
