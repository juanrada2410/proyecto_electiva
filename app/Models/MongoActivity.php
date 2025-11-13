<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder; // Requerido
use Illuminate\Database\Eloquent\Model as EloquentModel; // Requerido

/**
 * Modelo personalizado de Activity para almacenar registros en MongoDB.
 * CORREGIDO: Con todos los tipos de datos y return types.
 */
class MongoActivity extends Model implements ActivityContract
{
    /**
     * Conexión y colección.
     */
    protected $connection = 'mongodb';
    protected $collection = 'activity_log';

    /**
     * Spatie no usa timestamps por defecto.
     */
    public $timestamps = false;

    /**
     * Campos asignables.
     */
    protected $guarded = [];

    /**
     * Casts.
     */
    protected $casts = [
        'properties' => 'collection',
        'created_at' => 'datetime',
    ];

    /**
     * Constructor.
     */
    public function __construct(array $attributes = [])
    {
        // Usar la configuración si existe, si no, 'mongodb' por defecto.
        $this->connection = config('activitylog.database_connection') ?? 'mongodb';
        parent::__construct($attributes);
    }

    /**
     * Modelo que causó la actividad.
     */
    public function causer(): MorphTo
    {
        return $this->morphTo('causer');
    }

    /**
     * Modelo afectado por la actividad.
     */
    public function subject(): MorphTo
    {
        return $this->morphTo('subject');
    }

    /**
     * Devuelve una propiedad adicional dentro del campo 'properties'.
     */
    public function getExtraProperty(string $key, $default = null)
    {
        $props = $this->properties ?? [];
        return data_get($props, $key, $default);
    }

    /**
     * Devuelve los cambios almacenados en 'properties'.
     */
    public function changes(): array
    {
        $props = $this->properties ?? [];

        // Formato esperado: ['attributes' => ..., 'old' => ...]
        if (isset($props['attributes']) || isset($props['old'])) {
            return [
                'attributes' => (array) ($props['attributes'] ?? []),
                'old'        => (array) ($props['old'] ?? []),
            ];
        }

        if (isset($props['changes'])) {
            return (array) $props['changes'];
        }

        return [];
    }

    /**
     * Scope: actividades causadas por un modelo o ID específico.
     */
    public function scopeCausedBy(Builder $query, $causer): Builder
    {
        if ($causer instanceof EloquentModel) {
            return $query->where('causer_type', get_class($causer))
                         ->where('causer_id', (string) $causer->getKey());
        }

        return $query->where('causer_id', (string) $causer);
    }

    /**
     * Scope: actividades para un evento dado.
     */
    public function scopeForEvent(Builder $query, string $event): Builder
    {
        return $query->where('event', $event);
    }

    /**
     * Scope: actividades relacionadas con un modelo o ID de sujeto.
     */
    public function scopeForSubject(Builder $query, $subject): Builder
    {
        if ($subject instanceof EloquentModel) {
            return $query->where('subject_type', get_class($subject))
                         ->where('subject_id', (string) $subject->getKey());
        }

        return $query->where('subject_id', (string) $subject);
    }

    /**
     * Scope: actividades dentro de ciertos logs.
     */
    public function scopeInLog(Builder $query, ...$logNames): Builder
    {
        if (isset($logNames[0]) && is_array($logNames[0])) {
            $logNames = $logNames[0];
        }

        return $query->whereIn('log_name', $logNames);
    }
}
