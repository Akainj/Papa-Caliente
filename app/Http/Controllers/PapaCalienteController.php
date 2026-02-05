<?php

namespace App\Http\Controllers;

use App\Models\Numero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PapaCalienteController extends Controller
{
    private $miLaptop = 2;

    private $laptops = [
        1 => 'https://homer-unorphaned-thaddeus.ngrok-free.dev', 
        3 => 'https://unstorable-randall-unpitched.ngrok-free.dev',     
    ];

    public function iniciar()
    {
        return response()->json(['error' => 'Laptop 2 no inicia'], 403);
    }

    public function recibir(Request $request)
    {
        $numero = (int) $request->input('numero');

        Numero::create([
            'numero' => $numero,
            'from' => 'laptop 1'
        ]);

        Log::info("[LAPTOP 2] Recibí {$numero}");

        $this->enviarASiguiente($numero + 1);

        return response()->json([
            'ok' => true,
            'recibido' => $numero,
            'enviado' => $numero + 1
        ]);
    }

    private function enviarASiguiente($numero)
    {
        $url = $this->laptops[3] . '/api/recibir';

        Log::info("[LAPTOP 2] Enviando {$numero} a Laptop 3");

        Http::timeout(5)
            ->withHeaders(['ngrok-skip-browser-warning' => 'true'])
            ->post($url, [
                'numero' => $numero
            ]);
    }

    public function estado()
    {
        return response()->json([
            'laptop' => 2,
            'total' => Numero::count(),
            'maximo' => Numero::max('numero')
        ]);
    }
}
