<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model; 

class Branch extends Model 

{
     use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'branches';
    protected $fillable = ['name', 'address'];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Una sucursal puede tener muchos turnos.
     */
    public function turns(): HasMany
    {
        return $this->hasMany(Turn::class);
    }
}