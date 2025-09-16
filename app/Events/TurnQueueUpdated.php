<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Collection; // <-- 1. AÑADE ESTA LÍNEA
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TurnQueueUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * La colección de turnos actualizada.
     */
    public $turns;

    /**
     * Create a new event instance.
     */
    // 2. CAMBIA 'array' POR 'Collection' AQUÍ
    public function __construct(Collection $turns)
    {
        $this->turns = $turns;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('public-turns'),
        ];
    }
    
    /**
     * El nombre con el que se emitirá el evento.
     */
    public function broadcastAs()
    {
        return 'turn.queue.updated';
    }
}


    