<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de login/registro.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Muestra el formulario para introducir el PIN.
     */
    public function showPinForm()
    {
        // Si no hay un documento en la sesión, redirige al login
        if (!Session::has('document_for_verification')) {
            return redirect()->route('login')->with('error', 'Por favor, introduce tu documento primero.');
        }
        return view('verify-pin');
    }

    /**
     * Busca al usuario, genera un PIN y lo redirige a la página de verificación.
     */
    public function sendPin(Request $request)
    {
        $request->validate(['document_number' => 'required|string']);

        $user = User::where('document_number', $request->document_number)->first();

        if (!$user) {
            return back()->withErrors(['document_number' => 'El número de documento no está registrado.']);
        }

        // Genera un PIN de 4 dígitos
        $pin = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        
        // Guarda el PIN y su fecha de expiración (ej. 5 minutos)
        $user->pin = $pin;
        $user->pin_expires_at = now()->addMinutes(5);
        $user->save();

        // **LA LÍNEA CLAVE:** Guarda el documento en la sesión para el siguiente paso
        Session::put('document_for_verification', $user->document_number);

        // Guarda el PIN en el log para que puedas verlo durante el desarrollo
        Log::info('PIN de acceso para ' . $user->email . ': ' . $pin);

        // Redirige al usuario a la página para que ingrese el PIN
        return redirect()->route('verify-pin');
    }

    /**
     * Verifica el PIN y, si es correcto, inicia la sesión del usuario.
     */
    public function verifyPin(Request $request)
    {
        $request->validate(['pin' => 'required|digits:4']);

        // Recuperamos el documento que guardamos en la sesión
        $documentNumber = Session::get('document_for_verification');

        if (!$documentNumber) {
            return redirect()->route('login')->with('error', 'La sesión ha expirado. Por favor, inténtalo de nuevo.');
        }

        $user = User::where('document_number', $documentNumber)->first();

        if (!$user || $user->pin !== $request->pin) {
            return back()->withErrors(['pin' => 'El PIN es incorrecto.']);
        }

        if (now()->gt($user->pin_expires_at)) {
            return back()->withErrors(['pin' => 'El PIN ha expirado. Solicita uno nuevo.']);
        }

        // Limpia el PIN después de usarlo
        $user->pin = null;
        $user->pin_expires_at = null;
        $user->save();
        
        // Limpia la variable de sesión
        Session::forget('document_for_verification');

        // Inicia la sesión del usuario
        Auth::login($user);

        // Redirige según el rol del usuario
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'cashier') {
            return redirect()->route('cashier.dashboard');
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}