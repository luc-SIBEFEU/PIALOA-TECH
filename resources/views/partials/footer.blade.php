<footer class="bg-ink text-white mt-24">
    <div class="max-w-6xl mx-auto px-6 py-16 grid md:grid-cols-4 gap-10">
        <div class="md:col-span-2">
            <img src="{{ asset('images/logo.png') }}" alt="Pialoa Tech" class="h-9 w-auto mb-4 invert">
            <p class="text-white/60 text-sm max-w-sm leading-relaxed">
                Entreprise spécialisée dans le développement de solutions digitales et électroniques en météorologie.
            </p>
            <p class="text-white/60 text-sm max-w-sm leading-relaxed mt-4">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="underline text-sm">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="underline text-sm">Espace admin</a>
                @endauth
            </p>
            <div class="flex items-center gap-2 mt-6">
                <span class="dot-cluster"><span></span><span></span><span></span><span></span><span></span><span></span></span>
            </div>
        </div>

        <div>
            <h4 class="eyebrow mb-4">Navigation</h4>
            <ul class="space-y-2 text-sm text-white/70">
                <li><a href="{{ route('services.index') }}" class="hover:text-ember">Services</a></li>
                <li><a href="{{ route('produits.index') }}" class="hover:text-ember">Produits</a></li>
                <li><a href="{{ route('evenements.index') }}" class="hover:text-ember">Actualités</a></li>
                <li><a href="/stagiaire" class="hover:text-ember">Stagiaires</a></li>
                <li><a href="/avis" class="hover:text-ember">Avis</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-ember">À propos</a></li>
            </ul>
        </div>

        <div>
            <h4 class="eyebrow mb-4">Contact</h4>
            <ul class="space-y-2 text-sm text-white/70">
                <li><i class="bi bi-envelope"></i> <a href="mailto:contact@pialoa-tech.com">contact@pialoa-tech.com</a></li>
                <li><i class="bi bi-telephone"></i> <a href="tel:+237652206783">+237 652 206 783</a> (Cameroun) <br>
                    <a href="tel:+33776328880">+33 776 328 880</a> (france)</li>
                <li><i class="bi bi-globe"></i> <a href="https://www.pialoa-tech.com" target="_blank">www.pialoa-tech.com</a></li>
            </ul>
            <h4 class="eyebrow mt-4">Suivez-nous</h4>
            <ul class="flex items-center gap-4">
                <li><a href="#" class="text-white/70 hover:text-ember"><i class="bi bi-facebook"></i></a></li>
                <li><a href="#" class="text-white/70 hover:text-ember"><i class="bi bi-twitter"></i></a></li>
                <li><a href="#" class="text-white/70 hover:text-ember"><i class="bi bi-linkedin"></i></a></li>
                <li><a href="#" class="text-white/70 hover:text-ember"><i class="bi bi-instagram"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-white/10 py-6 text-center text-xs text-white/40">
        &copy; {{ now()->year }} Pialoa Tech. Tous droits réservés.
    </div>
</footer>
