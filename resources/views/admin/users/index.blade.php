<!DOCTYPE html>
<html lang="es">
<head>
    <title>Gestionar Usuarios - Administración</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light-gray">
    <div class="flex h-screen">
        <aside class="w-64 bg-banco-blue text-white flex-col hidden md:flex">
             <div class="p-6 text-center border-b border-white/20">
                <h2 class="text-xl font-bold">Administración</h2>
            </div>
            <nav class="flex-grow p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-white/10 transition">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center py-2.5 px-4 rounded-lg bg-white/20 font-semibold">Usuarios</a>
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
                <h1 class="text-xl font-bold text-gray-800">Gestión de Usuarios</h1>
                <span class="font-semibold">{{ Auth::user()->name }}</span>
            </header>
            <main class="flex-1 p-8 overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-banco-blue">Usuarios del Sistema</h2>
                    {{-- <a href="#" class="bg-banco-yellow text-banco-blue font-bold py-2 px-5 rounded-full hover:bg-yellow-400 transition">Crear Usuario</a> --}}
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="p-4 font-semibold">Nombre</th>
                                <th class="p-4 font-semibold">Email</th>
                                <th class="p-4 font-semibold">N° Documento</th>
                                <th class="p-4 font-semibold">Rol</th>
                                <th class="p-4 font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-4">{{ $user->name }}</td>
                                    <td class="p-4 text-gray-600">{{ $user->email }}</td>
                                    <td class="p-4 text-gray-600">{{ $user->document_number }}</td>
                                    <td class="p-4">
                                        <span class="px-3 py-1 text-xs rounded-full font-semibold
                                            @if($user->role == 'admin') bg-red-100 text-red-800 @endif
                                            @if($user->role == 'cashier') bg-yellow-100 text-yellow-800 @endif
                                            @if($user->role == 'client') bg-blue-100 text-blue-800 @endif
                                        ">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="p-4"><a href="#" class="text-banco-blue font-semibold hover:underline">Editar</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-8 text-gray-500">No se encontraron usuarios.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>