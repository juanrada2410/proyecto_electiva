<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Aquí irá la lógica de tu panel de administrador
        return "Bienvenido al Panel de Administrador"; 
    }
}
