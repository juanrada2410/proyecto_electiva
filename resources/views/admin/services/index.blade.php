@extends('layouts.admin')

@section('title', 'Servicios')
@section('header', 'Gestión de Servicios')

@section('content')
<!-- Mensaje de éxito -->
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-banco-blue">Servicios del Sistema</h2>
    <a href="{{ route('admin.services.create') }}" class="bg-banco-yellow text-banco-blue font-bold py-2 px-5 rounded-full hover:bg-yellow-400 transition">
        Crear Servicio
    </a>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 font-semibold">Nombre</th>
                <th class="p-4 font-semibold">Prefijo</th>
                <th class="p-4 font-semibold">Estado</th>
                <th class="p-4 font-semibold">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4">{{ $service->name }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 bg-banco-blue text-white rounded font-mono font-bold">
                            {{ $service->prefix }}
                        </span>
                    </td>
                    <td class="p-4">
                        <span class="px-3 py-1 text-xs rounded-full font-semibold
                            {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $service->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="p-4 space-x-2">
                        <a href="{{ route('admin.services.edit', $service->_id) }}" class="text-banco-blue font-semibold hover:underline">
                            Editar
                        </a>
                        <form action="{{ route('admin.services.destroy', $service->_id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este servicio?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 font-semibold hover:underline">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center p-8 text-gray-500">No hay servicios registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $services->links() }}
    </div>
</div>
@endsection
