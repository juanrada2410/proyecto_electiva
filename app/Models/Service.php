<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- Importa el trait aquí
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    
    // Campos que se pueden llenar
    protected $fillable = ['name'];

    /**
     * Un servicio puede tener muchos turnos.
     */
    public function turns()
    {
        return $this->hasMany(Turn::class);
    }
}
