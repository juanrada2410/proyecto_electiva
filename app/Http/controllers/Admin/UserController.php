<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra una lista de todos los usuarios.
     */
    public function index()
    {
        // Obtiene todos los usuarios, los más nuevos primero, y los pagina.
        $users = User::latest()->paginate(10); 

        // Envía la variable $users a la vista para que pueda ser usada.
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * (Lo llenaremos en el futuro)
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * (Lo llenaremos en el futuro)
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * (Lo llenaremos en el futuro)
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * (Lo llenaremos en el futuro)
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * (Lo llenaremos en el futuro)
     */
    public function destroy(User $user)
    {
        //
    }
}