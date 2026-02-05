<?php

namespace App\Http\Controllers;

use App\Models\Numero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PapaCalienteController extends Controller
{
    private int $miLaptop = 1;

    private array $laptops = [
        2 => 'https://unsenile-harmony-giddier.ngrok-free.dev',
        3 => 'https://unstorable-randall-unpitched.ngrok-free.dev',
    ];

    public function iniciar()
    {
        $numero = 1;

        Numero::create([
            'numero' => $numero,
            'origen' => 'laptop 1'
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
            'origen' => 'laptop 3'
        ]);

        Log::info("[LAPTOP 1] Recibí {$numero} desde Laptop 3");

        $this->enviarASiguiente($numero + 1);

        return response()->json([
            'ok' => true,
            'recibido' => $numero,
            'enviado' => $numero + 1
        ]);
    }

    private function enviarASiguiente(int $numero): void
    {
        try {
            $url = $this->laptops[2] . '/api/recibir';

            Log::info("[LAPTOP 1] Enviando {$numero} a Laptop 2");

            Http::timeout(10)
                ->withHeaders(['ngrok-skip-browser-warning' => 'true'])
                ->post($url, [
                    'numero' => $numero
                ]);
        } catch (\Throwable $e) {
            Log::error("[LAPTOP 1] Error enviando a Laptop 2: " . $e->getMessage());
        }
    }

    public function estado()
    {
        return response()->json([
            'laptop' => 1,
            'total_registros' => Numero::count(),
            'numero_maximo' => Numero::max('numero'),
        ]);
    }
}
