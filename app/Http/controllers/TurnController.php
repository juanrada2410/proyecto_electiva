<?php

// ¡Namespace corregido con 'C' mayúscula!
namespace App\Http\Controllers; 

use App\Events\TurnQueueUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\User;
use App\Models\turn as Turn; //
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Helpers\AuditHelper;

class TurnController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validar la solicitud
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $user_id = Auth::id();

        // 2. Verificar si el usuario ya tiene un turno activo
        $existingTurn = Turn::where('user_id', $user_id)
                            ->whereIn('status', ['waiting', 'attending'])
                            ->first();

        if ($existingTurn) {
            return redirect()->back()->with('error', 'Ya tienes un turno activo.');
        }

        // 3. Obtener el servicio y el prefijo
        $service = Service::find($request->service_id);
        if (!$service) {
            return redirect()->back()->with('error', 'Servicio no válido.');
        }
        $prefix = $service->prefix ?? 'G'; // Prefijo 'G' (General) si el servicio no tiene uno

        // 4. Encontrar el último número para ese prefijo
        $lastTurnNumber = Turn::where('turn_code', 'LIKE', $prefix . '-%')
                                ->whereDate('created_at', Carbon::today())
                                ->count();
        
        $newTurnNumber = $lastTurnNumber + 1;
        $turnCode = $prefix . '-' . str_pad($newTurnNumber, 3, '0', STR_PAD_LEFT);

        // 5. Crear el turno
        $turn = Turn::create([
            'user_id' => $user_id,
            'service_id' => $request->service_id,
            'turn_code' => $turnCode,
            'status' => 'waiting',
        ]);

        // Registrar auditoría
        AuditHelper::log('turn_request', "Solicitó turno {$turnCode} para {$service->name}");

        // (Opcional, para broadcasting)
        // event(new TurnQueueUpdated());

        return redirect()->route('dashboard')->with('success', 'Turno solicitado con éxito: ' . $turnCode);
    }

    /**
     * Cancel the user's active turn.
     */
    public function cancel(Turn $turn) 
    {
        // Verificar que el turno pertenezca al usuario autenticado
        if ($turn->user_id !== Auth::id()) {
            abort(403, 'Acción no autorizada.');
        }

        // Verificar que el turno aún esté 'waiting'
        if ($turn->status !== 'waiting') {
            return redirect()->back()->with('error', 'Este turno ya no puede ser cancelado.');
        }

        $turnCode = $turn->turn_code;
        $turn->update(['status' => 'cancelled']);
        
        // Registrar auditoría
        AuditHelper::log('turn_cancel', "Canceló su turno {$turnCode}");
        
        // (Opcional, para broadcasting)
        // event(new TurnQueueUpdated());

        return redirect()->route('dashboard')->with('success', 'Tu turno ha sido cancelado.');
    }
}