<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Turnos en Vivo - Banco de Bogotá</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --banco-blue: #14327D;
            --banco-yellow: #EBB932;
            --banco-red: #CD3232;
            --background-gray: #f4f6f9;
            --text-dark: #212529;
            --text-light: #ffffff;
            --border-color: #dee2e6;
        }
        body {
            font-family: 'Figtree', sans-serif;
            background-color: var(--background-gray);
            margin: 0;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 1000px;
            background-color: var(--text-light);
            border-radius: 16px;
            box-shadow: 0 12px 24px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #102862, var(--banco-blue));
            padding: 2rem 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid var(--banco-yellow);
        }
        .header .logo img {
            height: 45px;
            width: auto;
        }
        .header h1 {
            color: var(--text-light);
            font-size: 1.75rem;
            margin: 0;
            font-weight: 700;
        }
        .content {
            padding: 2.5rem;
        }
        .turn-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }
        .turn-table thead {
            background-color: var(--banco-blue);
            color: var(--text-light);
        }
        .turn-table th, .turn-table td {
            padding: 1rem;
            font-size: 1.1rem;
            border-bottom: 1px solid var(--border-color);
        }
        .turn-table th {
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .turn-table tbody tr:last-child td {
            border-bottom: none;
        }
        .turn-table .turn-code {
            font-weight: 700;
            font-size: 1.6rem;
            color: var(--banco-red);
        }
        .actions {
            padding: 1.5rem 2.5rem;
            background-color: var(--background-gray);
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            margin: 0 0.5rem;
            transition: all 0.2s ease-in-out;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background-color: var(--banco-yellow);
            color: var(--banco-blue);
            box-shadow: 0 4px 12px rgba(235, 185, 50, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(235, 185, 50, 0.4);
        }
        .btn-secondary {
            background-color: #6c757d;
            color: var(--text-light);
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body class="antialiased">
    <div class="container">
        <header class="header">
            <div class="logo">
                <img src="{{ asset('images/logo_banco_bogotá.png') }}" alt="Logo Banco de Bogotá">
            </div>
            <h1>Monitor de Turnos</h1>
        </header>

        <main class="content">
            <table class="turn-table">
                <thead>
                    <tr>
                        <th>Turno</th>
                        <th>Servicio</th>
                        <th>Módulo de Atención</th>
                    </tr>
                </thead>
                <tbody id="turn-queue-body">
                    
                    @if($turns->isNotEmpty())
                        @foreach($turns as $turn)
                            <tr>
                                <td class="turn-code">{{ $turn->turn_code }}</td>
                                <td>{{ $turn->service->name }}</td>
                                <td>Módulo 3</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" style="padding: 3rem; font-size: 1.2rem; color: #6c757d;">No hay turnos en espera.</td>
                        </tr>
                    @endif
                    </tbody>
            </table>
        </main>

        <footer class="actions">
            <a href="{{ route('login') }}" class="btn btn-primary">Solicitar Turno</a>
            <a href="#" class="btn btn-secondary">Soy Asesor</a>
        </footer>
    </div>
</body>
</html>