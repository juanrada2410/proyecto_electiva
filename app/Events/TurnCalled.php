<?php



namespace App\Events;

use App\Models\Turn;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TurnCalled
{
    use Dispatchable, SerializesModels;

    public $turn;
    public $module;

    public function __construct(Turn $turn, $module)
    {
        $this->turn = $turn;
        $this->module = $module;
    }
}