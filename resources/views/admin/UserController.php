<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // <-- 1. Importa el modelo User
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra una lista de todos los usuarios.
     */
    public function index()
    {
        // 2. Obtiene todos los usuarios, los más nuevos primero
        $users = User::latest()->paginate(10); // Pagina los resultados de 10 en 10

        // 3. Envía los usuarios a la vista
        return view('admin.users.index', compact('users'));
    }

    // ... (los otros métodos como create, store, etc., los llenaremos después)
    public function create() { }
    public function store(Request $request) { }
    public function show(User $user) { }
    public function edit(User $user) { }
    public function update(Request $request, User $user) { }
    public function destroy(User $user) { }
}