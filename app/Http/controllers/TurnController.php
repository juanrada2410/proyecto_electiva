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

        return view('dashboard', compact('services', 'myTurn'));
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

        $branchId = 1;
        $service = Service::find($request->service_id);
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

    private function broadcastQueueUpdate()
    {
        $turns = Turn::with(['service', 'branch'])
            ->whereIn('status', ['pending', 'attending'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        broadcast(new TurnQueueUpdated($turns));
    }
}