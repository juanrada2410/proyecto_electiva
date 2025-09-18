<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Cliente - Banco de Bogotá</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light-gray">
    <div class="flex h-screen">
        <aside class="w-64 bg-white shadow-md flex-col hidden md:flex">
            <div class="p-6 text-center border-b">
                <img src="{{ asset('img/logo_banco_bogota.png') }}" alt="Logo" class="h-10 mx-auto">
            </div>
            <nav class="flex-grow p-4 space-y-2">
                <a href="#" class="flex items-center py-2.5 px-4 rounded-lg bg-banco-blue/10 text-banco-blue font-semibold">
                    Resumen
                </a>
                <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-banco-blue/10 transition">
                    Solicitar Turno
                </a>
                 <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-banco-blue/10 transition">
                    Mis Turnos
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">Panel de Cliente</h1>
                <div class="flex items-center space-x-3">
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-banco-blue">Salir</button>
                    </form>
                </div>
            </header>
            <main class="flex-1 p-8 overflow-y-auto">
                <div class="bg-white p-8 rounded-lg shadow-md">
                     <h2 class="text-2xl font-bold text-banco-blue mb-2">Cola en Tiempo Real</h2>
                     <p class="text-gray-600 mb-6">Aquí puedes ver el estado actual de la fila y solicitar tu turno.</p>
                     {{-- Aquí iría la lógica para mostrar el turno o el formulario --}}
                     <div class="text-center text-gray-500 border-2 border-dashed rounded-lg p-12">
                         (Contenido dinámico del turno o formulario para solicitar)
                     </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>