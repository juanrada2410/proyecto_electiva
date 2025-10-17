<!DOCTYPE html>
<html lang="es">
<head>
    <title>Administración - Banco de Bogotá</title>
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
                {{-- <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-white/10 transition">Servicios</a> --}}
            </nav>
            <div class="p-4 border-t border-white/20">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left">Salir</button>
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
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="font-semibold text-gray-500">Usuarios Totales</h3>
                        <p class="text-3xl font-bold text-banco-blue">{{ $totalUsers }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="font-semibold text-gray-500">Cajeros Activos</h3>
                        <p class="text-3xl font-bold text-banco-blue">{{ $totalCashiers }}</p>
                    </div>
                    {{-- Tarjetas de ejemplo para el futuro --}}
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="font-semibold text-gray-500">Turnos Hoy</h3>
                        <p class="text-3xl font-bold text-banco-blue">0</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="font-semibold text-gray-500">Sucursales</h3>
                        <p class="text-3xl font-bold text-banco-blue">1</p>
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