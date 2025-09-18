<?php

namespace App\Http\Controllers;

use App\Events\TurnQueueUpdated;
use App\Models\Service;
use App\Models\Turn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TurnController extends Controller
{
    public function welcome()
    {
        $turns = Turn::with(['service', 'branch'])
            ->whereIn('status', ['pending', 'attending'])
            ->orderBy('created_at', 'asc')
            ->get();
            
        return view('welcome', compact('turns'));
    }

    public function dashboard()
    {
        $services = Service::where('is_active', true)->get();
        $myTurn = Turn::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'attending'])
            ->first();

        $turnsAhead = 0;
        if ($myTurn) {
            // Contamos los turnos del mismo servicio que se crearon antes y están pendientes
            $turnsAhead = Turn::where('service_id', $myTurn->service_id)
                               ->where('status', 'pending')
                               ->where('created_at', '<', $myTurn->created_at)
                               ->count();
        }

        return view('dashboard', compact('services', 'myTurn', 'turnsAhead'));
    }

    public function store(Request $request)
    {
        $request->validate(['service_id' => 'required|exists:services,id']);
        
        $existingTurn = Turn::where('user_id', Auth::id())
                             ->whereIn('status', ['pending', 'attending'])
                             ->exists();

        if ($existingTurn) {
            return redirect()->route('dashboard')->with('error', 'Ya tienes un turno activo.');
        }

        $branchId = 1; // Asumimos una única sucursal por ahora
        $service = Service::find($request->service_id);
        
        // Obtenemos el último número de turno para ese servicio y sucursal
        $lastTurnNumber = Turn::where('service_id', $service->id)
                                ->where('branch_id', $branchId)
                                ->max('turn_number');
        
        $newTurnNumber = $lastTurnNumber ? $lastTurnNumber + 1 : 1;

        $turn = Turn::create([
            'user_id' => Auth::id(),
            'service_id' => $service->id,
            'branch_id' => $branchId,
            'turn_code' => $service->prefix . str_pad($newTurnNumber, 3, '0', STR_PAD_LEFT),
            'turn_number' => $newTurnNumber,
            'status' => 'pending',
        ]);

        $this->broadcastQueueUpdate();
        
        Log::info("Evento TurnQueueUpdated disparado después de crear el turno: " . $turn->turn_code);

        return redirect()->route('dashboard')->with('success', 'Tu turno ha sido solicitado con éxito: ' . $turn->turn_code);
    }

    /**
     * Cancela el turno de un usuario.
     */
    public function cancel(Turn $turn)
    {
        // Verificamos que el usuario sea el dueño del turno
        if ($turn->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para cancelar este turno.');
        }

        $turn->update(['status' => 'cancelled']);

        $this->broadcastQueueUpdate();

        return redirect()->route('dashboard')->with('success', 'Tu turno ha sido cancelado.');
    }

    /**
     * Emite el evento de actualización de la cola.
     */
    private function broadcastQueueUpdate()
    {
        $turns = Turn::with(['service', 'branch'])
            ->whereIn('status', ['pending', 'attending'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Usamos broadcast() para enviar el evento a todos los clientes conectados
        broadcast(new TurnQueueUpdated($turns));
    }
}