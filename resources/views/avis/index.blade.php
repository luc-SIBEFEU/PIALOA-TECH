
@extends('layouts.app')

@section('title', 'Avis')
@section('content')

<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">

<style>
    .layer{
        margin-top: 50px;
        border: 1px solid #ccc;
        padding: 20px;
        width : 100%;
        background : white;
        border-radius :2%;
    }
    .form{
    display: flex;
    justify-content: center; /* Centrage horizontal */
    align-items: center; /* Centrage vertical */
    width: 100%;
    }
    a{
        text-decoration: none;
        color:white;
    }
    .close:hover{
        cursor: pointer;
    }
    .card{
        border-left: 7px solid #dba00a;
        border-radius: 15px;
    }
</style>

<div>
    <!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->
     <div class="container text">
        <section class="max-w-6xl mx-auto px-6 py-20">
        <span class="eyebrow">Retours Clients</span>
        <h1 class="text-4xl font-bold mt-2 mb-12">AVIS  </h1><span>
     <button class="btn-primary" onclick="display();">Ajouter un avis</button></span> 

    <div id="grid" class="grid mt-3 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @forelse ($avis as $avis)
                <div class="card flex flex-col">
                    <h2 class="font-display mb-2"><i class="bi bi-person-circle"></i> {{ $avis->nom }}</h2>
                    <h5 class="font-display text-sm leading-relaxed"><i class="bi bi-envelope"></i> {{ $avis->email }}</h5>
                    <p class="text-slate text-sm leading-relaxed mb-4">{{ $avis->message }}</p>
                </div>
            @empty
                <p class="text-slate">Aucun avis disponible pour le moment.</p>
            @endforelse
        </div>
     </div>
     <div class="form">
        <div class="lay">
     <form action="/avis" id="avis-form" style="display: none;" class="layer" method="POST">
        @csrf
        <div class="close" onclick="display();"><h2>&times;</h2></div>
        <div class="text-center mt-4">
            <label for="nom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
            <input type="text" id="nom" name="nom" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Votre nom" required>
        </div>
        <div class="text-center mt-4">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
            <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Votre email" required>
        </div>
        <div class="text-center mt-4">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Message</label>
            <textarea id="message" name="message" class="bg-gray-50 border border-gray-300 focus:ring-blue-5₀ focus:border-blue-5₀ block w-full p₂.₅ dark:bg-gray-7₀₀ dark:border-gray-6₀₀ dark:placeholder-gray₄₀₀ dark:focus:ring-blue-5₀₀ dark:focus:border-blue-5₀₀" placeholder="Votre message" required></textarea>
        </div>
        <br>
        <button type="submit" class="btn-primary !px-5 !py-2.5 text-sm">Ajouter un avis</button>
     </form>
     </div>
     </div>
</div>
<script>
    function display() {
        var form = document.getElementById("avis-form");
        let is_active = form.style.display === "block";
        let grid = document.getElementById("grid");
        if (is_active) {
            grid.style.display = "grid";
        } else {
            grid.style.display = "none";
        }
        if (form.style.display === "none") {
            form.style.display = "block";
        } else {
            form.style.display = "none";
        }
    }
</script>

@endsection

