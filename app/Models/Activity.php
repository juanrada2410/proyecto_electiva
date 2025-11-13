<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\MorphTo;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;

class Activity extends Model implements ActivityContract
{
    protected $connection = 'mongodb';
    protected $collection = 'activity_log';

    protected $guarded = [];

    protected $casts = [
        'properties' => 'collection',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    public function getExtraProperty(string $propertyName, mixed $defaultValue = null): mixed
    {
        return $this->properties->get($propertyName, $defaultValue);
    }

    public function changes(): \Illuminate\Support\Collection
    {
        return $this->properties->only(['attributes', 'old']);
    }

    public function scopeInLog($query, ...$logNames): void
    {
        if (is_array($logNames[0])) {
            $logNames = $logNames[0];
        }

        $query->whereIn('log_name', $logNames);
    }

    public function scopeCausedBy($query, $causer): void
    {
        $query
            ->where('causer_type', $causer->getMorphClass())
            ->where('causer_id', $causer->getKey());
    }

    public function scopeForSubject($query, $subject): void
    {
        $query
            ->where('subject_type', $subject->getMorphClass())
            ->where('subject_id', $subject->getKey());
    }

    public function scopeForEvent($query, $event): void
    {
        $query->where('event', $event);
    }
}
