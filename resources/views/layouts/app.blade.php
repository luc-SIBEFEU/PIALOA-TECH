<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pialoa Tech') | Entreprise de solutions digitales</title>
    <link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.min.css') }}">
    <meta name="description" content="@yield('meta_description', 'Pialoa Tech conçoit des sites internet, applications, solutions digitales et stations météo connectées.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen">

    @include('partials.navbar')

    <main class="flex-1">
        @if (session('success'))
            <div class="max-w-6xl mx-auto px-6 mt-6">
                <div class="bg-moss/10 border border-moss text-moss px-4 py-3 rounded-lg text-sm font-medium">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
