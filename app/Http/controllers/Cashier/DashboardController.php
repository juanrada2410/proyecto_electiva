<?php

namespace App\Http\Controllers\Cashier;

use App\Events\TurnCalled;
use App\Events\TurnQueueUpdated;
use App\Http\Controllers\Controller;
use App\Models\Turn;
use App\Models\User; // <-- También añadimos el modelo User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $cashier = Auth::user();
        // Asumimos que el cajero atiende el servicio "Caja" (ID 1)
        // En un futuro, esto debería ser dinámico.
        $serviceId = 1;

        $currentTurn = Turn::where('assigned_cashier_id', $cashier->id)
                            ->where('status', 'attending')
                            ->with('user', 'service')
                            ->first();

        $pendingTurns = Turn::where('service_id', $serviceId)
                            ->where('status', 'pending')
                            ->with('user')
                            ->orderBy('created_at', 'asc')
                            ->get();

        return view('cashier.dashboard', compact('currentTurn', 'pendingTurns'));
    }

    public function callTurn()
    {
        $cashier = Auth::user();
        $serviceId = 1;

        $nextTurn = Turn::where('service_id', $serviceId)
                        ->where('status', 'pending')
                        ->orderBy('created_at', 'asc')
                        ->first();

        if ($nextTurn) {
            $nextTurn->update([
                'status' => 'attending',
                'assigned_cashier_id' => $cashier->id,
                'called_at' => now(),
            ]);

            broadcast(new TurnCalled($nextTurn, 'Módulo 5'));
            $this->broadcastQueueUpdate();
            
            Log::info("Cajero {$cashier->id} llamó al turno {$nextTurn->turn_code}");

            return redirect()->route('cashier.dashboard')->with('success', "Has llamado al turno {$nextTurn->turn_code}.");
        }

        return redirect()->route('cashier.dashboard')->with('error', 'No hay turnos en espera para llamar.');
    }

    public function finishTurn(Turn $turn)
    {
        if ($turn->assigned_cashier_id !== Auth::id()) {
            return redirect()->route('cashier.dashboard')->with('error', 'Este turno no te corresponde.');
        }

        $turn->update([
            'status' => 'finished',
            'finished_at' => now(),
        ]);

        $this->broadcastQueueUpdate();

        return redirect()->route('cashier.dashboard')->with('success', "Turno {$turn->turn_code} finalizado correctamente.");
    }
    
    private function broadcastQueueUpdate()
    {
        $turns = Turn::with(['service', 'branch'])
            ->whereIn('status', ['pending', 'attending'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        broadcast(new TurnQueueUpdated($turns));
    }
}