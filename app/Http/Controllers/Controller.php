<?php

namespace App\Http\Controllers;

use App\Models\Numero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PapaCalienteController extends Controller
{
    private $miLaptop = 3;

    private $laptops = [
        1 => 'https://homer-unorphaned-thaddeus.ngrok-free.dev',
        2 => 'https://unsenile-harmony-giddier.ngrok-free.dev', 
    ];

    public function iniciar()
    {
        return response()->json(['error' => 'Laptop 3 no inicia'], 403);
    }

git    public function recibir(Request $request)
    {
        $numero = (int) $request->input('numero');

        Numero::create([
            'numero' => $numero,
            'from' => 'laptop 2'
        ]);

        Log::info("[LAPTOP 3] Recibí {$numero}");

        $this->enviarASiguiente($numero + 1);

        return response()->json([
            'ok' => true,
            'recibido' => $numero,
            'enviado' => $numero + 1
        ]);
    }

    private function enviarASiguiente($numero)
    {
        $url = $this->laptops[1] . '/api/recibir';

        Log::info("[LAPTOP 3] Enviando {$numero} a Laptop 1");

        Http::timeout(5)
            ->withHeaders(['ngrok-skip-browser-warning' => 'true'])
            ->post($url, [
                'numero' => $numero
            ]);
    }

    public function estado()
    {
        return response()->json([
            'laptop' => 3,
            'total' => Numero::count(),
            'maximo' => Numero::max('numero')
        ]);
    }
}
