<?php

// NOTA IMPORTANTE: Hemos quitado 'Auth' del namespace para simplificar.
namespace App\Http\Controllers; 

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function sendPin(Request $request)
    {
        $request->validate(['document_number' => 'required|string']);
        $user = User::where('document_number', $request->document_number)->first();

        if (!$user) {
            return back()->withErrors(['document_number' => 'El número de documento no se encuentra registrado.']);
        }

        $pin = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        session([
            'login_pin' => $pin,
            'pin_expires_at' => now()->addMinutes(5),
            'user_id_to_verify' => $user->id,
        ]);

        Log::info("PIN de inicio de sesión para el usuario {$user->email}: {$pin}");
        return redirect()->route('verify-pin');
    }

    public function showPinForm()
    {
        if (!session()->has('user_id_to_verify')) {
            return redirect()->route('login')->withErrors('Por favor, introduce primero tu documento.');
        }
        return view('verify-pin');
    }

    public function verifyPin(Request $request)
    {
        $request->validate(['pin' => 'required|digits:4']);

        if (!session()->has('login_pin') || session('pin_expires_at') < now()) {
            return redirect()->route('login')->withErrors('El PIN ha expirado. Por favor, solicita uno nuevo.');
        }

        if ($request->pin == session('login_pin')) {
            $user = User::find(session('user_id_to_verify'));
            session()->forget(['login_pin', 'pin_expires_at', 'user_id_to_verify']);
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors(['pin' => 'El PIN es incorrecto.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}