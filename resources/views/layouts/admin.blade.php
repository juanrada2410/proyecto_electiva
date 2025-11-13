<!DOCTYPE html>
<html lang="es">
<head>
    <title>@yield('title', 'Administración') - Banco de Bogotá</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light-gray">
    <div class="flex h-screen">
        <aside class="w-64 bg-banco-blue text-white flex-col hidden md:flex">
             <div class="p-6 text-center border-b border-white/20">
                <h2 class="text-xl font-bold">Administración</h2>
            </div>
            <nav class="flex-grow p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center py-2.5 px-4 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }} transition">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center py-2.5 px-4 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }} transition">Usuarios</a>
                <a href="{{ route('admin.audits.index') }}" class="flex items-center py-2.5 px-4 rounded-lg {{ request()->routeIs('admin.audits.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }} transition">Auditorías</a>
            </nav>
            <div class="p-4 border-t border-white/20">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left py-2.5 px-4 rounded-lg hover:bg-white/10 transition">Salir</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">@yield('header', 'Administración')</h1>
                <span class="font-semibold">{{ Auth::user()->name }}</span>
            </header>
            <main class="flex-1 p-8 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
