<?php

namespace App\Http\Controllers;

use App\Http\Services\AltaPasajeroServices;
use Illuminate\Http\Request;

class AltaPasajeroController extends Controller
{
    protected $services = null;
    
    function __construct()
    {
        $this->services = new AltaPasajeroServices();
    }

    public function empresasDisponibles(Request $request)
    {
        return $this->services->empresasDisponiblesServices($request);
    }

    function altaPasajero(Request $request)
    {
        return $this->services->altaPasajeroServices($request);
    }

    function guardar(Request $request)
    {
        return $this->services->guardarServices($request);
    }

    public function obtenerTipoDocumento(Request $request)
    {
        return $this->services->obtenerTipoDocumentoServices($request);
    }

    public function obtenerPaises(Request $request)
    {
        return $this->services->obtenerPaisesServices($request);
    }
}
