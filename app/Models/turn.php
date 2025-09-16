<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Turn extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'service_id',
        'branch_id',
        'turn_code',
        'turn_number',
        'status',
        'called_at',
        'finished_at',
    ];

    /**
     * Define la relación: Un turno pertenece a un Usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define la relación: Un turno pertenece a un Servicio.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Define la relación: Un turno pertenece a una Sucursal.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}