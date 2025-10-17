<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard principal de administración.
     */
    public function index()
    {
        // Obtenemos datos reales para el dashboard
        $totalUsers = User::count();
        $totalCashiers = User::where('role', 'cashier')->count();
        $recentUsers = User::latest()->take(5)->get(); // Tomamos los últimos 5 usuarios registrados

        // Enviamos los datos a la vista
        return view('admin.dashboard', compact('totalUsers', 'totalCashiers', 'recentUsers'));
    }
}