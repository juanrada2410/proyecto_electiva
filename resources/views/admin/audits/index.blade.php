@extends('layouts.admin')

@section('title', 'Auditorías')
@section('header', 'Auditorías del Sistema')

@section('content')
<!-- Gráficas -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Acciones por tipo -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-banco-blue mb-4">Acciones por Tipo</h3>
        <canvas id="actionsChart"></canvas>
    </div>

    <!-- Actividad diaria -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-banco-blue mb-4">Actividad (Últimos 7 días)</h3>
        <canvas id="dailyChart"></canvas>
    </div>

    <!-- Usuarios más activos -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-banco-blue mb-4">Usuarios Más Activos</h3>
        <canvas id="usersChart"></canvas>
    </div>
</div>

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

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfica de acciones por tipo
    const actionsCtx = document.getElementById('actionsChart').getContext('2d');
    new Chart(actionsCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($actionLabels) !!},
            datasets: [{
                data: {!! json_encode($actionData) !!},
                backgroundColor: [
                    '#004a99', // Azul banco
                    '#ffc107', // Amarillo banco
                    '#dc3545', // Rojo
                    '#28a745', // Verde
                    '#17a2b8', // Cyan
                    '#6c757d', // Gris
                    '#fd7e14', // Naranja
                    '#6f42c1', // Púrpura
                    '#e83e8c', // Rosa
                    '#20c997'  // Teal
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });

    // Gráfica de actividad diaria
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    const gradient = dailyCtx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 74, 153, 0.8)');
    gradient.addColorStop(1, 'rgba(255, 193, 7, 0.8)');
    
    new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($dailyLabels) !!},
            datasets: [{
                label: 'Acciones',
                data: {!! json_encode($dailyData) !!},
                backgroundColor: gradient,
                borderColor: '#004a99',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 74, 153, 0.9)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            return 'Acciones: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });

    // Gráfica de usuarios más activos
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    new Chart(usersCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($userLabels) !!},
            datasets: [{
                label: 'Acciones',
                data: {!! json_encode($userData) !!},
                backgroundColor: '#ffc107',
                borderColor: '#004a99',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection
