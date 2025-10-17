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
                <a href="{{ route('dashboard') }}" class="flex items-center py-2.5 px-4 rounded-lg bg-banco-blue/10 text-banco-blue font-semibold">
                    Mi Turno
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
                        <button type="submit" class="text-gray-600 hover:text-banco-blue transition">Salir</button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-8 overflow-y-auto">

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 mb-6 rounded-md shadow-sm" role="alert">
                        <p class="font-bold">¡Éxito!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if(session('error'))
                     <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-md shadow-sm" role="alert">
                        <p class="font-bold">Error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @if($myTurn)
                    <div class="bg-white p-8 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold text-banco-blue text-center">Tu Turno Actual</h2>
                        <div class="text-center my-6 p-8 bg-banco-blue/5 border-2 border-dashed border-banco-blue rounded-lg">
                            <p class="text-gray-700 text-lg">Servicio solicitado:</p>
                            <p class="text-2xl font-semibold text-banco-blue mb-4">{{ $myTurn->service->name }}</p>
                            <p class="text-gray-700 text-lg">Tu código de turno es:</p>
                            <p class="text-7xl font-bold text-banco-blue my-2">{{ $myTurn->turn_code }}</p>
                            <div class="mt-6 bg-banco-yellow text-banco-blue font-bold p-4 rounded-lg text-lg">
                                Hay {{ $turnsAhead }} personas delante de ti.
                            </div>
                        </div>
                        <form action="{{ route('turns.cancel', $myTurn) }}" method="POST" class="text-center" onsubmit="return confirm('¿Estás seguro de que deseas cancelar tu turno?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-600 hover:text-red-600 underline transition">Cancelar mi turno</button>
                        </form>
                    </div>
                @else
                    <div class="bg-white p-8 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold text-banco-blue">Solicitar un Nuevo Turno</h2>
                        <p class="text-gray-600 mt-2 mb-6">Selecciona el servicio que necesitas para generar tu turno.</p>
                        <form action="{{ route('turns.store') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="service_id" class="block text-sm font-medium text-gray-700">Servicio</label>
                                    <select name="service_id" id="service_id" class="mt-1 block w-full p-3 border-gray-300 rounded-lg shadow-sm focus:ring-banco-yellow focus:border-banco-yellow" required>
                                        <option value="" disabled selected>-- Elige una opción --</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-banco-yellow text-banco-blue font-bold py-3 px-4 rounded-lg hover:bg-yellow-400 transition-transform transform hover:scale-105">
                                    Confirmar y Solicitar Turno
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </main>
        </div>
    </div>
</body>
</html>