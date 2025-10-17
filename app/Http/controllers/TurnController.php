<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Turn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TurnController extends Controller
{
    /**
     * Muestra la página de bienvenida con la cola de turnos públicos.
     */
    public function welcome()
    {


        return view('welcome', compact('turns'));
    }

    /**
     * Muestra el panel del cliente.
     */
    public function dashboard()
    {
        // Buscamos si el usuario actual tiene un turno activo
        $myTurn = Turn::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'attending'])
            ->with('service')
            ->first();

        $turnsAhead = 0;
        if ($myTurn) {
            // Si tiene un turno, calculamos cuántos hay delante en la misma cola
            $turnsAhead = Turn::where('service_id', $myTurn->service_id)
                               ->where('status', 'pending')
                               ->where('created_at', '<', $myTurn->created_at)
                               ->count();
        }

        // Obtenemos la lista de servicios para el formulario de solicitud
        $services = Service::where('is_active', true)->get();

        return view('dashboard', compact('myTurn', 'turnsAhead', 'services'));
    }

    /**
     * Almacena un nuevo turno en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate(['service_id' => 'required|exists:services,id']);

        // Verificamos que el usuario no tenga ya un turno activo
        if (Turn::where('user_id', Auth::id())->whereIn('status', ['pending', 'attending'])->exists()) {
            return redirect()->route('dashboard')->with('error', 'Ya tienes un turno activo.');
        }

        $service = Service::find($request->service_id);

        // Lógica para generar el número del turno (reinicia cada día por servicio)
        $lastTurnNumber = Turn::where('service_id', $service->id)->whereDate('created_at', today())->max('turn_number');
        $newTurnNumber = $lastTurnNumber ? $lastTurnNumber + 1 : 1;

        $turn = Turn::create([
            'user_id' => Auth::id(),
            'service_id' => $service->id,
            'branch_id' => 1, // Asumimos una única sucursal por ahora
            'turn_code' => $service->prefix . '-' . str_pad($newTurnNumber, 3, '0', STR_PAD_LEFT),
            'turn_number' => $newTurnNumber,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Tu turno ' . $turn->turn_code . ' ha sido solicitado con éxito.');
    }

    /**
     * Cancela el turno de un usuario.
     */
    public function cancel(Turn $turn)
    {
        // Verificamos que el usuario sea el dueño del turno para evitar que cancele turnos ajenos
        if ($turn->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para cancelar este turno.');
        }

        $turn->update(['status' => 'cancelled']);

        return redirect()->route('dashboard')->with('success', 'Tu turno ha sido cancelado exitosamente.');
    }
}