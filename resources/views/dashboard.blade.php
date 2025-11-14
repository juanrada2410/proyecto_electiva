<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Cliente - Sistema de Turnos</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_banco_bogota.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div class="min-h-full">
        <nav class="bg-banco-blue shadow-lg">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-auto" src="{{ asset('img/logo_banco_bogota.png') }}" alt="Logo Banco">
                        </div>
                        <span class="text-white font-bold text-xl ml-4">Sistema de Turnos</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-white font-medium">Hola, {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 transition">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <h1 class="text-xl font-semibold leading-tight tracking-tight text-gray-900">
                    Bienvenido a tu Panel
                </h1>
            </div>
        </header>

        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="md:col-span-1 space-y-6">
                        
                        @if ($myTurn)
                        <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-banco-blue">
                            <div class="bg-gradient-to-r from-banco-blue to-blue-700 px-6 py-5">
                                <h3 class="text-xl font-bold text-white">Tu Turno Actual</h3>
                            </div>
                            <div class="px-6 py-8">
                                <div class="text-center">
                                    <div class="bg-banco-blue rounded-2xl p-6 mb-4">
                                        <span class="text-6xl font-extrabold text-white">{{ $myTurn->turn_code }}</span>
                                    </div>
                                    <p class="text-xl font-semibold text-gray-700 mb-2">{{ $myTurn->service->name }}</p>
                                    <div class="mt-6 bg-banco-yellow rounded-lg p-4">
                                        <p class="font-bold text-banco-blue text-lg">
                                            {{ $turnsAhead }} {{ $turnsAhead == 1 ? 'persona' : 'personas' }} delante de ti
                                        </p>
                                    </div>
                                    <form action="{{ route('turn.cancel', $myTurn->id) }}" method="POST" class="mt-6" onsubmit="return confirm('¿Estás seguro de cancelar tu turno?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full rounded-lg bg-red-600 px-4 py-3 text-sm font-bold text-white hover:bg-red-700 transition shadow-md">
                                            Cancelar mi turno
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @else
                        <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-banco-yellow">
                            <div class="bg-gradient-to-r from-banco-yellow to-yellow-500 px-6 py-5">
                                <h3 class="text-xl font-bold text-banco-blue">Solicitar un Nuevo Turno</h3>
                            </div>
                            <div class="px-6 py-8">
                                <form action="{{ route('turn.store') }}" method="POST">
                                    @csrf
                                    <div>
                                        <label for="service_id" class="block text-sm font-bold text-gray-700 mb-2">Selecciona el Servicio</label>
                                        <select name="service_id" id="service_id" class="block w-full rounded-lg border-2 border-gray-300 px-4 py-3 focus:border-banco-blue focus:ring-2 focus:ring-banco-blue text-base" required>
                                            <option value="" disabled selected>-- Elige una opción --</option>
                                            
                                            @forelse($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @empty
                                                <option value="" disabled>No hay servicios disponibles</option>
                                            @endforelse
                                            
                                        </select>
                                    </div>
                                    <button type="submit" class="mt-6 w-full rounded-lg bg-banco-blue px-4 py-3 text-base font-bold text-white shadow-lg hover:bg-blue-700 transition transform hover:scale-105">
                                        Confirmar y Solicitar Turno
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif

                    </div>
                    
                    <div class="md:col-span-2">
                        <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                            <div class="bg-gradient-to-r from-banco-blue to-blue-700 px-6 py-5">
                                <h3 class="text-xl font-bold text-white">Cola de Turnos en Vivo</h3>
                            </div>
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-4 pl-6 pr-3 text-left text-sm font-bold text-gray-700">Turno</th>
                                            <th scope="col" class="px-3 py-4 text-left text-sm font-bold text-gray-700">Servicio</th>
                                            <th scope="col" class="px-3 py-4 text-left text-sm font-bold text-gray-700">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @forelse ($publicTurns as $turn)
                                            <tr class="{{ $turn->status == 'attending' ? 'bg-banco-yellow bg-opacity-20' : 'hover:bg-gray-50' }} transition">
                                                <td class="whitespace-nowrap py-5 pl-6 pr-3 text-3xl font-extrabold {{ $turn->status == 'attending' ? 'text-banco-blue' : 'text-gray-700' }}">
                                                    {{ $turn->turn_code }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-base font-medium text-gray-700">
                                                    {{ $turn->service->name }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5">
                                                    @if ($turn->status == 'attending')
                                                        <span class="inline-flex items-center rounded-full bg-banco-blue px-4 py-2 text-sm font-bold text-white shadow-md">
                                                            <svg class="mr-2 h-3 w-3 animate-pulse" fill="currentColor" viewBox="0 0 8 8">
                                                                <circle cx="4" cy="4" r="3" />
                                                            </svg>
                                                            Atendiendo
                                                        </span>
                                                    @else
                                                        <span class="inline-flex rounded-full bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700">
                                                            En espera
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-6 py-12 text-center">
                                                    <div class="text-gray-400">
                                                        <svg class="mx-auto h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <p class="text-lg font-medium">No hay turnos en espera</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</body>
</html>