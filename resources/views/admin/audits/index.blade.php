@extends('layouts.admin')

@section('title', 'Auditorías')
@section('header', 'Auditorías del Sistema')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <!-- Filtros -->
    <form method="GET" action="{{ route('admin.audits.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
            <input type="text" name="user_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-banco-blue focus:border-transparent" value="{{ request('user_name') }}" placeholder="Buscar por nombre">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Acción</label>
            <select name="action" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-banco-blue focus:border-transparent">
                <option value="">Todas las acciones</option>
                @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                        {{ ucfirst($action) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
            <input type="date" name="date_from" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-banco-blue focus:border-transparent" value="{{ request('date_from') }}">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
            <input type="date" name="date_to" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-banco-blue focus:border-transparent" value="{{ request('date_to') }}">
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="px-4 py-2 bg-banco-blue text-white rounded-lg hover:bg-banco-blue-dark transition">Filtrar</button>
            <a href="{{ route('admin.audits.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">Limpiar</a>
        </div>
    </form>

    <!-- Tabla de auditorías -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3 font-semibold text-gray-700">Usuario</th>
                    <th class="p-3 font-semibold text-gray-700">Acción</th>
                    <th class="p-3 font-semibold text-gray-700">Descripción</th>
                    <th class="p-3 font-semibold text-gray-700">IP</th>
                    <th class="p-3 font-semibold text-gray-700">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($audits as $audit)
                <tr class="hover:bg-gray-50 border-b">
                    <td class="p-3">
                        <div>
                            <p class="font-medium text-gray-900">{{ $audit->user_name }}</p>
                            <p class="text-sm text-gray-500">{{ $audit->user_email }}</p>
                        </div>
                    </td>
                    <td class="p-3">
                        <span class="px-3 py-1 text-xs rounded-full font-semibold
                            @if($audit->action == 'login') bg-green-100 text-green-800
                            @elseif($audit->action == 'logout') bg-gray-100 text-gray-800
                            @elseif(str_contains($audit->action, 'create')) bg-blue-100 text-blue-800
                            @elseif(str_contains($audit->action, 'update')) bg-yellow-100 text-yellow-800
                            @elseif(str_contains($audit->action, 'delete')) bg-red-100 text-red-800
                            @else bg-purple-100 text-purple-800
                            @endif">
                            {{ ucfirst($audit->action) }}
                        </span>
                    </td>
                    <td class="p-3 text-gray-700">{{ $audit->description }}</td>
                    <td class="p-3 text-gray-600 text-sm">{{ $audit->ip_address }}</td>
                    <td class="p-3 text-gray-600 text-sm">{{ $audit->created_at->format('d/m/Y H:i:s') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-500">
                        No hay registros de auditoría
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $audits->links() }}
    </div>
</div>
@endsection
