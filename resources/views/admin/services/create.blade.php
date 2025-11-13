@extends('layouts.admin')

@section('title', 'Crear Servicio')
@section('header', 'Crear Nuevo Servicio')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('admin.services.store') }}">
            @csrf

            <!-- Nombre -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Servicio</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-banco-blue focus:border-transparent @error('name') border-red-500 @enderror" 
                    required placeholder="Ej: Caja, Asesoría, Créditos">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Prefijo -->
            <div class="mb-4">
                <label for="prefix" class="block text-sm font-medium text-gray-700 mb-1">Prefijo (para turnos)</label>
                <input type="text" name="prefix" id="prefix" value="{{ old('prefix') }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-banco-blue focus:border-transparent @error('prefix') border-red-500 @enderror" 
                    required maxlength="5" placeholder="Ej: C, A, P" style="text-transform: uppercase;">
                <p class="text-xs text-gray-500 mt-1">Máximo 5 caracteres. Se usará para generar códigos de turno (Ej: C-001)</p>
                @error('prefix')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estado -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} 
                        class="w-4 h-4 text-banco-blue border-gray-300 rounded focus:ring-banco-blue">
                    <span class="ml-2 text-sm font-medium text-gray-700">Servicio activo</span>
                </label>
                <p class="text-xs text-gray-500 mt-1">Los servicios inactivos no estarán disponibles para solicitar turnos</p>
            </div>

            <!-- Botones -->
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-banco-blue text-white rounded-lg hover:bg-banco-blue-dark transition">
                    Crear Servicio
                </button>
                <a href="{{ route('admin.services.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Convertir el prefijo a mayúsculas automáticamente
    document.getElementById('prefix').addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });
</script>
@endsection
