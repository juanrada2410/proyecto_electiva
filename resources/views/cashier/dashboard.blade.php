<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel de Cajero - Banco de Bogotá</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light-gray">
    <div class="flex h-screen">
        <aside class="w-64 bg-banco-blue text-white flex-col hidden md:flex">
            <div class="p-6 text-center border-b border-white/20">
                <h2 class="text-xl font-bold">Panel de Cajero</h2>
            </div>
            <nav class="flex-grow p-4 space-y-2">
                <a href="#" class="flex items-center py-2.5 px-4 rounded-lg bg-white/20 font-semibold">
                    Mi Módulo
                </a>
            </nav>
            <div class="p-4 border-t border-white/20">
                <form action="{{ route('logout') }}" method="POST">
                    <button type="submit" class="w-full text-left">Salir</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
             <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">Servicio: Caja</h1>
                <span class="font-semibold">{{ Auth::user()->name }}</span>
            </header>
            <main class="flex-1 p-8 grid md:grid-cols-3 gap-8">
                <div class="md:col-span-1 bg-white p-6 rounded-lg shadow-lg flex flex-col justify-between">
                     <div>
                        <h2 class="text-xl font-bold text-banco-blue">Atendiendo Ahora</h2>
                        <div class="text-center my-4">
                            <p class="text-7xl font-extrabold text-banco-blue">C-001</p>
                            <p class="mt-2 text-gray-600">Cliente: Ana María</p>
                        </div>
                    </div>
                    <button class="w-full bg-green-500 text-white font-bold py-3 rounded-lg hover:bg-green-600 transition">Finalizar Atención</button>
                </div>
                <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-banco-blue">Cola de Espera (3)</h2>
                        <button class="bg-banco-yellow text-banco-blue font-bold py-3 px-6 rounded-lg hover:bg-yellow-400 transition">Llamar Siguiente</button>
                    </div>
                    <div class="space-y-3">
                        <div class="bg-gray-100 p-4 rounded-md font-semibold text-gray-700">C-002</div>
                        <div class="bg-gray-100 p-4 rounded-md font-semibold text-gray-700">C-003</div>
                        <div class="bg-gray-100 p-4 rounded-md font-semibold text-gray-700">C-004</div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>