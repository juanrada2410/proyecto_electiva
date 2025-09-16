<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Banco de Bogotá</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Figtree', sans-serif; background-color: #f3f4f6; }
        .container { max-width: 800px; margin: 50px auto; padding: 20px; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1, h2 { color: #1a202c; }
        .form-select { width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #ef3340; color: white; border-radius: 4px; text-decoration: none; font-weight: bold; border: none; cursor: pointer; }
        .btn:hover { background-color: #d4222f; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .turn-card { background-color: #eef; padding: 20px; border-radius: 8px; text-align: center; border: 2px solid #ccd; }
        .turn-code { font-size: 2.5em; font-weight: bold; color: #ef3340; }
        .logout-form { display: inline; }
    </style>
</head>
<body class="antialiased">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Bienvenido, {{ Auth::user()->name }}</h1>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="btn">Cerrar Sesión</button>
            </form>
        </div>

        <hr style="margin: 20px 0;">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($myTurn)
            <h2>Tu Turno Actual</h2>
            <div class="turn-card">
                <p>Estás en la fila para el servicio de:</p>
                <h3>{{ $myTurn->service->name }}</h3>
                <p>Tu turno es:</p>
                <div class="turn-code">{{ $myTurn->turn_code }}</div>
                <p style="margin-top: 15px;">Por favor, espera a ser llamado. Serás notificado en esta pantalla.</p>
            </div>
        @else
            <h2>Solicitar un Nuevo Turno</h2>
            <p>Selecciona el servicio que necesitas y presiona "Solicitar Turno".</p>
            <form action="{{ route('turns.store') }}" method="POST">
                @csrf
                <div>
                    <label for="service_id">Servicio:</label>
                    <select name="service_id" id="service_id" class="form-select" required>
                        <option value="" disabled selected>-- Elige una opción --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-top: 20px;">
                    <button type="submit" class="btn">Solicitar Turno</button>
                </div>
            </form>
        @endif

    </div>
</body>
</html>