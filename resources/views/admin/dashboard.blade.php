<!DOCTYPE html>
<html lang="es">
<head>
    <title>Administración - Banco de Bogotá</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_banco_bogota.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light-gray">
    <div class="flex h-screen">
        <aside class="w-64 bg-banco-blue text-white flex-col hidden md:flex">
             <div class="p-6 text-center border-b border-white/20">
                <h2 class="text-xl font-bold">Administración</h2>
            </div>
            <nav class="flex-grow p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center py-2.5 px-4 rounded-lg bg-white/20 font-semibold">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-white/10 transition">Usuarios</a>
                <a href="{{ route('admin.services.index') }}" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-white/10 transition">Servicios</a>
                <a href="{{ route('admin.audits.index') }}" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-white/10 transition">Auditorías</a>
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
                <h1 class="text-xl font-bold text-gray-800">Resumen del Sistema</h1>
                <span class="font-semibold">{{ Auth::user()->name }}</span>
            </header>
            <main class="flex-1 p-8 overflow-y-auto">
                 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-banco-blue">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-500 text-sm">Usuarios Totales</h3>
                                <p class="text-3xl font-bold text-banco-blue mt-2">{{ $totalUsers }}</p>
                            </div>
                            <svg class="w-12 h-12 text-banco-blue opacity-20" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-banco-yellow">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-500 text-sm">Cajeros Activos</h3>
                                <p class="text-3xl font-bold text-banco-blue mt-2">{{ $totalCashiers }}</p>
                            </div>
                            <svg class="w-12 h-12 text-banco-yellow opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-500 text-sm">Turnos Hoy</h3>
                                <p class="text-3xl font-bold text-banco-blue mt-2">{{ $turnsToday }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $completedToday }} completados</p>
                            </div>
                            <svg class="w-12 h-12 text-green-500 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-500 text-sm">Servicios Activos</h3>
                                <p class="text-3xl font-bold text-banco-blue mt-2">{{ $totalServices }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $activeTurns }} en cola</p>
                            </div>
                            <svg class="w-12 h-12 text-purple-500 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                 <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-banco-blue mb-4">Últimos Usuarios Registrados</h2>
                     <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="p-3 font-semibold">Nombre</th>
                                <th class="p-3 font-semibold">Email</th>
                                <th class="p-3 font-semibold">Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUsers as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3">{{ $user->name }}</td>
                                <td class="p-3 text-gray-600">{{ $user->email }}</td>
                                <td class="p-3">
                                    <span class="px-3 py-1 text-xs rounded-full font-semibold
                                        @if($user->role == 'admin') bg-red-100 text-red-800 @endif
                                        @if($user->role == 'cashier') bg-yellow-100 text-yellow-800 @endif
                                        @if($user->role == 'client') bg-blue-100 text-blue-800 @endif
                                    ">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center p-8 text-gray-500">No hay usuarios registrados.</td>
                            </tr>
                            @endforelse
                        </tbody>
                     </table>
                 </div>
            </main>
        </div>
    </div>
</body>
</html>