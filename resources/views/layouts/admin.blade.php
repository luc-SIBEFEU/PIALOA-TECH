<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tableau de bord') | Administration Pialoa Tech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-paper font-body text-ink">
    <div class="flex min-h-screen">
        @include('admin.partials.sidebar')

        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-16 bg-white border-b border-slate/10 flex items-center justify-between px-6">
                <h1 class="font-display font-semibold text-lg">@yield('title', 'Tableau de bord')</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate hidden sm:inline">{{ auth()->user()->name }}</span>
                    <a href="{{ route('home') }}" class="text-sm font-display font-semibold text-ember hover:text-ink">Voir le site &rarr;</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-display font-semibold text-claret hover:text-ink">Déconnexion</button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-6">
                @if (session('success'))
                    <div class="bg-moss/10 border border-moss text-moss px-4 py-3 rounded-lg text-sm font-medium mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-claret/10 border border-claret text-claret px-4 py-3 rounded-lg text-sm font-medium mb-6">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
