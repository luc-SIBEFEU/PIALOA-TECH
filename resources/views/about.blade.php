@extends('layouts.app')

@section('title', 'À propos')

@section('content')
    <section class="max-w-4xl mx-auto px-6 py-20">
        <span class="eyebrow">Qui sommes-nous</span>
        <h1 class="text-4xl font-bold mt-2 mb-8">À propos de Pialoa Tech</h1>

        <div class="flex items-center gap-2 mb-8">
            <span class="dot-cluster"><span></span><span></span><span></span><span></span><span></span><span></span></span>
        </div>

        <p class="text-lg text-slate leading-relaxed mb-6">
            Pialoa Tech est une entreprise spécialisée dans le développement de solutions digitales et
            électroniques en météorologie. Nous accompagnons nos clients dans la conception de sites internet,
            d'applications web et mobiles, ainsi que dans le déploiement de stations météo connectées et de
            solutions d'automatisme industriel.
        </p>
        <p class="text-lg text-slate leading-relaxed mb-6">
            Notre équipe combine expertise technique et sens du design pour livrer des produits fiables,
            esthétiques et adaptés aux réalités du terrain.
        </p>

        <div class="grid sm:grid-cols-3 gap-6 mt-12">
            <div class="card text-center">
                <p class="text-3xl font-display font-bold text-ember">100%</p>
                <p class="text-sm text-slate mt-2">Solutions sur mesure</p>
            </div>
            <div class="card text-center">
                <p class="text-3xl font-display font-bold text-moss">24/7</p>
                <p class="text-sm text-slate mt-2">Maintenance &amp; support</p>
            </div>
            <div class="card text-center">
                <p class="text-3xl font-display font-bold text-claret">+</p>
                <p class="text-sm text-slate mt-2">Innovation continue</p>
            </div>
        </div>
    </section>
@endsection
