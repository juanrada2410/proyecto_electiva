{{-- Heredar de una plantilla base sería ideal, pero por ahora lo hacemos completo --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Gestionar Usuarios</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        {{-- Aquí iría el mismo <aside> del dashboard del admin para consistencia --}}
        <aside class="w-64 bg-banco-blue text-white flex-col hidden md:flex">
             <div class="p-6 text-center border-b border-white/20">
                <img src="{{ asset('img/logo_banco_bogota.png') }}" alt="Logo" class="h-10 mx-auto invert brightness-0">
                <h2 class="text-xl font-bold mt-2">Administración</h2>
            </div>
            <nav class="flex-grow p-4 space-y-2">
                <a href="#" class="block py-2.5 px-4 rounded-lg hover:bg-white/10 transition">Dashboard</a>
                <a href="#" class="block py-2.5 px-4 rounded-lg bg-white/20 font-semibold">Gestionar Usuarios</a>
                <a href="#" class="block py-2.5 px-4 rounded-lg hover:bg-white/10 transition">Gestionar Servicios</a>
            </nav>
            <div class="p-4 border-t border-white/20">
                 <p class="text-sm">Admin: <strong>{{ Auth::user()->name ?? 'Admin' }}</strong></p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full mt-2 bg-banco-red text-white font-bold py-2 px-4 rounded-lg hover:bg-opacity-90 transition">Cerrar Sesión</button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-10 overflow-y-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Usuarios del Sistema</h1>
                <a href="#" class="bg-banco-yellow text-banco-blue font-bold py-2 px-4 rounded-lg hover:bg-opacity-90 transition">Crear Nuevo Usuario</a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-4">Nombre</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Rol</th>
                            <th class="p-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="p-4">Admin Prueba</td>
                            <td class="p-4">admin@prueba.com</td>
                            <td class="p-4"><span class="bg-banco-red text-white px-2 py-1 text-xs rounded-full">Admin</span></td>
                            <td class="p-4"><a href="#" class="text-banco-blue hover:underline">Editar</a></td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-4">Cajero Prueba</td>
                            <td class="p-4">cajero@prueba.com</td>
                            <td class="p-4"><span class="bg-banco-yellow text-banco-blue px-2 py-1 text-xs rounded-full">Cajero</span></td>
                            <td class="p-4"><a href="#" class="text-banco-blue hover:underline">Editar</a></td>
                        </tr>
                         <tr class="border-b">
                            <td class="p-4">Cliente Prueba</td>
                            <td class="p-4">cliente@prueba.com</td>
                            <td class="p-4"><span class="bg-gray-200 text-gray-800 px-2 py-1 text-xs rounded-full">Cliente</span></td>
                            <td class="p-4"><a href="#" class="text-banco-blue hover:underline">Editar</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>