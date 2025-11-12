<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendLoginPin;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // Importante

class LoginController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function showLoginForm()
    {
        return view('login'); 
    }

    /**
     * Maneja la solicitud de login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // --- INICIO DE CORRECCIÓN ---
            // 1. Guardamos los datos que necesitamos ANTES de cerrar sesión
            $userId = $user->id;
            $userEmail = $user->email;
            
            // 2. Generar y guardar PIN
            $pin = random_int(100000, 999999);
            $user->login_pin = $pin;
            $user->pin_expires_at = now()->addMinutes(10);
            $user->save();

            // 3. Log de depuración
            Log::info('--- PIN DE ACCESO (DEPURACIÓN): ' . $pin . ' ---');
            
            // 4. Desconectar temporalmente
            // ¡Esta línea se movió! Cerramos la sesión ANTES de poner los nuevos datos.
            Auth::logout();

            // 5. Guardar ID de usuario y email en la NUEVA sesión
            Session::put('user_id_for_pin_verification', $userId);
            Session::put('email_for_pin_verification', $userEmail); // Guardamos el email también
            Session::save(); // Forzar el guardado

            Log::info('DIAGNÓSTICO (login): Sesión guardada para ID: ' . $userId);
            // --- FIN DE CORRECCIÓN ---

            // 6. Redirigir a la vista de verificación de PIN
            // Ya no usamos ->with('email'), lo leeremos desde la sesión
            return redirect()->route('verify-pin'); 
        }

        return redirect()->back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->withInput($request->only('email'));
    }

    /**
     * Muestra el formulario de verificación de PIN.
     */
    public function showPinForm()
    {
        Log::info('DIAGNÓSTICO (showPinForm): Entrando. Revisando la sesión...');
        
        if (!Session::has('user_id_for_pin_verification')) {
            Log::warning('DIAGNÓSTICO (showPinForm): ¡FALLO! Sesión no encontrada. Rebotando a login.');
            return redirect()->route('login')->withErrors(['email' => 'Por favor, inicia sesión primero.']);
        }
        
        Log::info('DIAGNÓSTICO (showPinForm): ¡ÉXITO! Sesión encontrada. Mostrando formulario de PIN.');
        
        // --- INICIO DE CORRECCIÓN ---
        // Leemos el email desde la sesión que guardamos
        $email = Session::get('email_for_pin_verification'); 
        // --- FIN DE CORRECCIÓN ---
        
        return view('auth.verify-pin', ['email' => $email]);
    }

    /**
     * Verifica el PIN ingresado.
     */
    public function verifyPin(Request $request)
    {
        $request->validate([
            'pin' => 'required|numeric|digits:6',
        ]);

        $userId = Session::pull('user_id_for_pin_verification');
        Session::forget('email_for_pin_verification'); // Limpiamos el email
        
        if (!$userId) {
            return redirect()->route('login')->withErrors(['email' => 'Tu sesión ha expirado. Por favor, inicia sesión de nuevo.']);
        }

        $user = User::find($userId);

        if (!$user || $user->login_pin !== $request->pin) {
            // Si el PIN es incorrecto, lo re-guarda en sesión para reintentar
            Session::put('user_id_for_pin_verification', $userId); 
            Session::put('email_for_pin_verification', $user->email ?? null); // Guardamos de nuevo el email
            return redirect()->back()->withErrors(['pin' => 'El PIN ingresado es incorrecto.'])->with('email', $user->email ?? null);
        }

        if (now()->gt($user->pin_expires_at)) {
            return redirect()->route('login')->withErrors(['email' => 'El PIN ha expirado. Por favor, inicia sesión de nuevo.']);
        }

        // Limpiar PIN
        $user->login_pin = null;
        $user->pin_expires_at = null;
        $user->save();

        // ¡Éxito! Iniciar sesión del usuario
        Auth::login($user);
        $request->session()->regenerate();

        // Redirigir basado en rol
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Determina a dónde redirigir después del login.
     */
    protected function redirectPath()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return '/admin/dashboard';
        } elseif ($user->role === 'cashier') {
            return '/cashier/dashboard';
        }
        
        return '/dashboard'; 
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