<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
// aquí Uso el Authenticatable de MongoDB
use MongoDB\Laravel\Auth\User as Authenticatable; 

class User extends Authenticatable //  Extiendo el Authenticatable de MongoDB
{
    use HasFactory, Notifiable;

    /**
     */
    protected $connection = 'mongodb';
     /**
     */
    protected $collection = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name','email', 'password','document_number',  'phone',
        'role', // Agregado para el registro
        'pin', //  Agregado para el login con PIN
        'pin_expires_at', //  Agregado para el login con PIN
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pin', 
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'pin_expires_at' => 'datetime', 
            'created_at' => 'datetime', 
            'updated_at' => 'datetime', 
            
        ];
    }

    /**
     * Un usuario (cliente) puede tener muchos turnos.
     */
    public function turns(): HasMany
    {
        return $this->hasMany(Turn::class);
    }
}