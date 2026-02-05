<?php

namespace App\Http\Controllers;

use App\Models\Numero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PapaCalienteController extends Controller
{
    private $miLaptop = 1;

    private $laptops = [
        2 => 'https://unsenile-harmony-giddier.ngrok-free.dev',
        3 => 'https://unstorable-randall-unpitched.ngrok-free.dev',
    ];

    public function iniciar()
    {
        $numero = 1;

        Numero::create([
            'numero' => $numero,
            'from' => 'laptop 1'
        ]);

        Log::info("[LAPTOP 1] Juego iniciado con {$numero}");

        $this->enviarASiguiente($numero);

        return response()->json([
            'ok' => true,
            'mensaje' => 'Juego iniciado',
            'numero' => $numero
        ]);
    }

    public function recibir(Request $request)
    {
        $numero = (int) $request->input('numero');

        Numero::create([
            'numero' => $numero,
            'from' => 'laptop 3'
        ]);

        Log::info("[LAPTOP 1] Recibí {$numero} desde Laptop 3");

        $this->enviarASiguiente($numero + 1);

        return response()->json([
            'ok' => true,
            'recibido' => $numero,
            'enviado' => $numero + 1
        ]);
    }

    private function enviarASiguiente($numero)
    {
        $url = $this->laptops[2] . '/api/recibir';

        Log::info("[LAPTOP 1] Enviando {$numero} a Laptop 2");

        Http::timeout(5)
            ->withHeaders([
                'ngrok-skip-browser-warning' => 'true'
            ])
            ->post($url, [
                'numero' => $numero
            ]);
    }

    public function estado()
    {
        return response()->json([
            'total' => Numero::count(),
            'maximo' => Numero::max('numero')
        ]);
    }
}