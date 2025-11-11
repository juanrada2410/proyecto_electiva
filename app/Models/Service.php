<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model; 

class Service extends Model 
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'services';
    
    protected $fillable = [
        'name',
        'prefix', // <--- Agregado (lo usa el Seeder)
        'is_active', // <--- Agregado (lo usa el Seeder)
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean', 
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Un servicio puede tener muchos turnos.
     */
    public function turns(): HasMany
    {
        return $this->hasMany(Turn::class);
    }
}
