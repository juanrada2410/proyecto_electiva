<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
     use HasFactory;

    // Campos que se pueden llenar
    protected $fillable = ['name', 'address'];

    /**
     * Una sucursal puede tener muchos turnos.
     */
    public function turns()
    {
        return $this->hasMany(Turn::class);
    }
}
