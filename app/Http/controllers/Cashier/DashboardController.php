<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Turn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $cashier = Auth::user();
        // Asumimos que el cajero siempre atiende el servicio con ID 1 (Caja).
        // Esto se puede hacer más dinámico en el futuro.
        $serviceId = 1;

        // Busca el turno que el cajero podría estar atendiendo actualmente
        $currentTurn = Turn::where('assigned_cashier_id', $cashier->id)
                            ->where('status', 'attending')
                            ->with('user', 'service')
                            ->first();

        // Busca todos los turnos pendientes para el servicio de este cajero
        $pendingTurns = Turn::where('service_id', $serviceId)
                            ->where('status', 'pending')
                            ->with('user')
                            ->orderBy('created_at', 'asc')
                            ->get();

        return view('cashier.dashboard', compact('currentTurn', 'pendingTurns'));
    }

    // ... (Aquí irían las futuras funciones para llamar y finalizar turnos)
}