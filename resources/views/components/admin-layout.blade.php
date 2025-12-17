@props(['title' => 'Admin', 'header' => 'Dashboard'])

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - CoWork Manager</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    @include('layouts.admin-sidebar')

    <div class="ml-64">
        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between h-16 px-6">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ $header }}
                </h2>
            </div>
        </header>

        <main class="p-6">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
