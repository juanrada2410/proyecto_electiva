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
                <a href="#" class="flex items-center py-2.5 px-4 rounded-lg bg-white/20 font-semibold">Dashboard</a>
                <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-white/10 transition">Usuarios</a>
                <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-white/10 transition">Servicios</a>
                <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-white/10 transition">Reportes</a>
            </nav>
            <div class="p-4 border-t border-white/20">
                <form action="{{ route('logout') }}" method="POST">
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
                        <p class="text-3xl font-bold text-banco-blue">150</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="font-semibold text-gray-500">Cajeros Activos</h3>
                        <p class="text-3xl font-bold text-banco-blue">12</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="font-semibold text-gray-500">Turnos Hoy</h3>
                        <p class="text-3xl font-bold text-banco-blue">432</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="font-semibold text-gray-500">Sucursales</h3>
                        <p class="text-3xl font-bold text-banco-blue">1</p>
                    </div>
                </div>
                <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-banco-blue mb-4">Últimos Usuarios Registrados</h2>
                     <table class="w-full text-left">
                        <thead>
                            <tr class="border-b">
                                <th class="p-3">Nombre</th><th class="p-3">Email</th><th class="p-3">Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-3">Admin Prueba</td><td class="p-3">admin@prueba.com</td><td class="p-3">Admin</td>
                            </tr>
                             <tr>
                                <td class="p-3">Cajero Prueba</td><td class="p-3">cajero@prueba.com</td><td class="p-3">Cajero</td>
                            </tr>
                        </tbody>
                     </table>
                 </div>
            </main>
        </div>
    </div>
</body>
</html>