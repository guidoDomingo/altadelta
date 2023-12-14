<?php

use App\Http\Controllers\AltaPasajeroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('alta', [AltaPasajeroController::class, "altaPasajero"]);

Route::get('pruebalaravel', function(){

        $empresas = \DB::table('credenciales_empresas')->where('deleted_at','=',null)->where('api_prefix','=','delta')->get();
            
        foreach($empresas as $empresa){
            
            $objeto [] = [
                "id_empresa" => $empresa->id,
                "nombre_empresa" => $empresa->nombre,
                "codigo_empresa" => $empresa->codigo,
            ];
        }

        $respuesta['error'] = false;
        $respuesta['message'] = "Empresas disponibles";
        $respuesta['message_user'] = "Empresas disponibles";
        $respuesta['data'] = $objeto;

        return $respuesta;
});
