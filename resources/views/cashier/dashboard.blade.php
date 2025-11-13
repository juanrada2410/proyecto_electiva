<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel de Cajero - Banco de Bogotá</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_banco_bogota.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light-gray">
    <div class="flex h-screen">
        <aside class="w-64 bg-banco-blue text-white flex-col hidden md:flex">
            <div class="p-6 text-center border-b border-white/20">
                <h2 class="text-xl font-bold">Panel de Cajero</h2>
            </div>
            <nav class="flex-grow p-4 space-y-2">
                <a href="#" class="flex items-center py-2.5 px-4 rounded-lg bg-white/20 font-semibold">
                    Mi Módulo
                </a>
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
                <h1 class="text-xl font-bold text-gray-800">Servicio: Caja</h1>
                <span class="font-semibold">{{ Auth::user()->name }}</span>
            </header>
            <main class="flex-1 p-8">
                <!-- Mensajes -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('error') }}
                    </div>
                @endif
                @if(session('info'))
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('info') }}
                    </div>
                @endif

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="md:col-span-1 bg-white p-6 rounded-lg shadow-lg flex flex-col justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-banco-blue mb-4">Atendiendo Ahora</h2>
                            @if($currentTurn)
                                <div class="text-center my-4">
                                    <p class="text-7xl font-extrabold text-banco-blue">{{ $currentTurn->turn_code }}</p>
                                    <p class="mt-2 text-gray-600">Cliente: {{ $currentTurn->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $currentTurn->service->name ?? 'Caja' }}</p>
                                </div>
                            @else
                                <div class="text-center my-8">
                                    <p class="text-gray-400 text-lg">Sin turno en atención</p>
                                    <p class="text-sm text-gray-500 mt-2">Presiona "Llamar Siguiente" para comenzar</p>
                                </div>
                            @endif
                        </div>
                        @if($currentTurn)
                            <form action="{{ route('cashier.finish-current') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-green-500 text-white font-bold py-3 rounded-lg hover:bg-green-600 transition">
                                    Finalizar Atención
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-banco-blue">Cola de Espera ({{ $pendingTurns->count() }})</h2>
                            <form action="{{ route('cashier.call-next') }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-banco-yellow text-banco-blue font-bold py-3 px-6 rounded-lg hover:bg-yellow-400 transition">
                                    Llamar Siguiente
                                </button>
                            </form>
                        </div>
                        <div class="space-y-3">
                            @forelse($pendingTurns as $turn)
                                <div class="bg-gray-100 p-4 rounded-md flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold text-gray-700">{{ $turn->turn_code }}</span>
                                        <span class="text-sm text-gray-500 ml-3">{{ $turn->user->name ?? 'N/A' }}</span>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ $turn->created_at->format('H:i') }}</span>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-400">
                                    No hay turnos en espera
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>