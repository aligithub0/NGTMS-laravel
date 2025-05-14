<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - Dashboard</title>
    
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="h-full font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex h-full">
        <!-- Mobile sidebar -->
        @include('layouts.partials.mobile-sidebar')
        
        <!-- Static sidebar for desktop -->
        @include('layouts.partials.sidebar')
        
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top navigation -->
            @include('layouts.partials.header')
            
            <!-- Main content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 focus:outline-none p-6">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>