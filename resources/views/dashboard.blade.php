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
        <nav class="bg-blue-900 shadow-md">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-auto" src="{{ asset('img/logo_banco_bogota.png') }}" alt="Logo Banco">
                        </div>
                        <span class="text-white font-semibold text-xl ml-4">Sistema de Turnos</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-300 mr-4">Hola, {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
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
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="bg-blue-600 px-4 py-5 sm:p-6">
                                <h3 class="text-lg font-medium leading-6 text-white">Tu Turno Actual</h3>
                            </div>
                            <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                                <div class="text-center">
                                    <span class="text-5xl font-bold text-gray-900">{{ $myTurn->turn_code }}</span>
                                    <p class="mt-2 text-lg font-medium text-gray-600">Servicio: {{ $myTurn->service->name }}</p>
                                    <div class="mt-4 bg-yellow-100 border-l-4 border-yellow-400 p-4">
                                        <p class="font-bold text-yellow-800">Hay {{ $turnsAhead }} personas delante de ti.</p>
                                    </div>
                                    <form action="{{ route('turn.cancel', $myTurn->id) }}" method="POST" class="mt-6">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full rounded-md bg-red-100 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-200">
                                            Cancelar mi turno
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @else
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="bg-green-600 px-4 py-5 sm:p-6">
                                <h3 class="text-lg font-medium leading-6 text-white">Solicitar un Nuevo Turno</h3>
                            </div>
                            <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                                <form action="{{ route('turn.store') }}" method="POST">
                                    @csrf
                                    <div>
                                        <label for="service_id" class="block text-sm font-medium text-gray-700">Servicio</label>
                                        <select name="service_id" id="service_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                            <option value="" disabled selected>-- Elige una opción --</option>
                                            
                                            @forelse($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @empty
                                                <option value="" disabled>No hay servicios disponibles</option>
                                            @endforelse
                                            
                                        </select>
                                    </div>
                                    <button type="submit" class="mt-6 w-full rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                                        Confirmar y Solicitar Turno
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif

                    </div>
                    
                    <div class="md:col-span-2">
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="bg-gray-800 px-4 py-5 sm:p-6">
                                <h3 class="text-lg font-medium leading-6 text-white">Cola de Turnos en Vivo</h3>
                            </div>
                            <div class="border-t border-gray-200">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Turno</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Servicio</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @forelse ($publicTurns as $turn)
                                            <tr class="{{ $turn->status == 'attending' ? 'bg-blue-100' : '' }}">
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-2xl font-bold sm:pl-6 {{ $turn->status == 'attending' ? 'text-blue-700' : 'text-gray-900' }}">
                                                    {{ $turn->turn_code }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">
                                                    {{ $turn->service->name }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                                    @if ($turn->status == 'attending')
                                                        <span class="inline-flex rounded-full bg-blue-200 px-3 py-1 text-sm font-semibold leading-5 text-blue-800">
                                                            Atendiendo
                                                        </span>
                                                    @else
                                                        <span class="inline-flex rounded-full bg-gray-200 px-3 py-1 text-sm font-semibold leading-5 text-gray-800">
                                                            En espera
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                                                    No hay turnos en espera en este momento.
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