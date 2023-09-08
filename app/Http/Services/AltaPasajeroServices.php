<?php 

namespace App\Http\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use SoapClient;


class altaPasajeroServices
{

    protected $agencia;
    protected $usuario;
    protected $password;
    protected $url;

    function __construct()
    {

        $this->agencia = "APP";

        $this->usuario   = "gEstIoN";

        $this->password = "aPpTioN";

        $this->url = "http://servidordeltapy.dyndns.org/expresoparaguay/wsdelta.asmx?wsdl";
    }

    function altaPasajeroServices($request)
    {
       $data = $request->all();
       $tipo_documento = (object) $this->obtenerTipoDocumentoServices($request);
       $paises = (object) $this->obtenerPaisesServices($request);
       $usuario = (object) $this->consultaPasajeroServices(new Request(array("tipo_documento" => $data['tipo_documento'], "numero_documento" => $data['numero_documento'] )));
       $nombre = $usuario->data["Nombre"] ?? "";
       $apellido = $usuario->data["Apellido"] ?? "";

       return view("delta.alta")->with("tipo_documento",$tipo_documento->data)->with("paises",$paises->data)->with("nombre",$nombre)
                                ->with("apellido",$apellido)
                                ->with("tipo_doc", $data['tipo_documento'])
                                ->with("numero_documento", $data['numero_documento']);

    }

    function guardarServices($request)
    {
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                "tipo_documento" => "required",
                "documento" => "required",
                "apellido" => "required",
                "nombre" => "required",
                "ocupacion" => "required",
                "fecha_nacimiento" => "required",
                "sexo" => "required",
                "nacionalidad" => "required",
                "residencia" => "required",
                "telefono" => "required",
            ]);

            if ($validator->fails()) {
                $request->session()->flash('failed', 'Campos obligatorios!');
                return Redirect::back();
            }

            $options = [
                'trace' => 1,
                'exceptions' => true,
                'cache_wsdl' => WSDL_CACHE_NONE,
                'stream_context' => stream_context_create([
                    'http' => [
                        'headers' => 'Content-Type: text/xml; charset=utf-8',
                    ]
                ])
            ];

            $wsdl = $this->url;
            $client = new SoapClient($wsdl, $options);
            $params = array(
                "TipoDocumento" => $data['tipo_documento'],
                "NroDocumento" => $data['documento'],
                "Apellido" => $data['apellido'],
                "Nombre" => $data['nombre'],
                "Ocupacion" => $data['ocupacion'],
                "FechaNacimiento" => $data['fecha_nacimiento'],
                "Sexo" => $data['sexo'],
                "Nacionalidad" => $data['nacionalidad'],
                "PaisResidencia" => $data['residencia'],
                "Telefono" => $data['telefono'],
                'Agencia' => $this->agencia,
                'Usuario' => $this->usuario,
                'Password' => $this->password
            );

            $response = $client->__soapCall('PasajerosAlta', [$params]);

            $responseXml = $response->PasajerosAltaResult->any;
            $responseData = simplexml_load_string($responseXml);
            $array = json_decode(json_encode($responseData), false);

            if ($array->NewDataSet->Pasajeros_AM2->Error == "0") {

                
                $request->session()->flash('success', 'Operación realizada con éxito! Ya puedes terminar la compra de tu pasaje !!');
                return Redirect::back();
            
                
            } else {

                $request->session()->flash('failed', 'No se pudo guardar los datos! vuelve a intentarlo !!');
                return Redirect::back();
            }
        } catch (Exception $e) {
            $response = [
                "error" => true,
                "message" => $e->getMessage(),
                "message_user" => "No se pudo dar de alta al pasajero"
            ];

            return $response;
        }
    }

    public function obtenerTipoDocumentoServices($request)
    {
        try {

            $data = $request->all();

            $options = [
                'trace' => 1,
                'exceptions' => true,
                'cache_wsdl' => 'WSDL_CACHE_NONE',
                'stream_context' => stream_context_create([
                    'http' => [
                        'headers' => 'Content-Type: text/xml; charset=utf-8',
                    ]
                ])
            ];

            $wsdl = $this->url;
            $client = new SoapClient($wsdl, $options);
            $params = array(
                'Agencia' => $this->agencia,
                'Usuario' => $this->usuario,
                'Password' => $this->password
            );

            $response = $client->__soapCall('TiposDocumentoGrilla', [$params]);

            $responseXml = $response->TiposDocumentoGrillaResult->any;
            $responseData = simplexml_load_string($responseXml);
            $array = json_decode(json_encode($responseData), false);

            $response = [
                "error" => false,
                "message" => "Tipo de documento obtenidos",
                "message_user" => "Tipo de documento obtenidos",
                "data" => $array->NewDataSet->TiposDeDocumento_Grilla2
            ];


            return $response;
        } catch (Exception $e) {
            $response = [
                "error" => true,
                "message" => $e->getMessage(),
                "message_user" => "No se pudo obtener el tipo de documento"
            ];

            return $response;
        }
    }

    public function obtenerPaisesServices($request)
    {
        try {

            $data = $request->all();

            $options = [
                'trace' => 1,
                'exceptions' => true,
                'cache_wsdl' => WSDL_CACHE_NONE,
                'stream_context' => stream_context_create([
                    'http' => [
                        'headers' => 'Content-Type: text/xml; charset=utf-8',
                    ]
                ])
            ];

            $wsdl = $this->url;
            $client = new SoapClient($wsdl, $options);
            $params = array(
                'Agencia' => $this->agencia,
                'Usuario' => $this->usuario,
                'Password' => $this->password
            );

            $response = $client->__soapCall('PaisesGrilla', [$params]);

            $responseXml = $response->PaisesGrillaResult->any;
            $responseData = simplexml_load_string($responseXml);
            $array = json_decode(json_encode($responseData), false);

            $response = [
                "error" => false,
                "message" => "Paises obtenidos",
                "message_user" => "Paises obtenidos",
                "data" => $array->NewDataSet->Paises_Grilla2
            ];


            return $response;
        } catch (Exception $e) {
            $response = [
                "error" => true,
                "message" => $e->getMessage(),
                "message_user" => "No se pudo obtener el pais"
            ];

            return $response;
        }
    }

    public function consultaPasajeroServices($request)
    {
        try {

            $data = $request->all();
            $validator = Validator::make($data, [
                "numero_documento" => "required",
                "tipo_documento" => "required"
            ]);

            if ($validator->fails()) {
                $response = [
                    "error" => true,
                    "message" => "Campos obligatorios no completados",
                    "message_user" => "Campos obligatorios no completados"
                ];

                return $response;
            }

            $options = [
                'trace' => 1,
                'exceptions' => true,
                'cache_wsdl' => WSDL_CACHE_NONE,
                'stream_context' => stream_context_create([
                    'http' => [
                        'headers' => 'Content-Type: text/xml; charset=utf-8',
                    ]
                ])
            ];

            $wsdl = $this->url;
            $client = new SoapClient($wsdl, $options);
            $params = array(
                "TipoDocumento" => $data['tipo_documento'],
                "NroDocumento" => $data['numero_documento'],
                'Agencia' => $this->agencia,
                'Usuario' => $this->usuario,
                'Password' => $this->password
            );

            $response = $client->__soapCall('Pasajeros_Consulta', [$params]);

            $responseXml = $response->Pasajeros_ConsultaResult->any;
            $responseData = simplexml_load_string($responseXml);

            $array = json_decode(json_encode($responseData), false);


            if ($array->NewDataSet->Pasajeros_Consulta->ExisteEnPN == "S") {


                $objeto = [
                    "tipo_documento" => !is_object($array->NewDataSet->Pasajeros_Consulta->Doctip ?? "") ? trim($array->NewDataSet->Pasajeros_Consulta->Doctip ?? "") : '',
                    "numero_documento" => !is_object($array->NewDataSet->Pasajeros_Consulta->DocNro ?? "") ? trim($array->NewDataSet->Pasajeros_Consulta->DocNro ?? "") : "",
                    "Apellido" =>  !is_object($array->NewDataSet->Pasajeros_Consulta->PasApe) ? trim($array->NewDataSet->Pasajeros_Consulta->PasApe) : '',
                    "Nombre" => !is_object($array->NewDataSet->Pasajeros_Consulta->PasNom) ? trim($array->NewDataSet->Pasajeros_Consulta->PasNom) : '',
                    "Ocupacion" => !is_object($array->NewDataSet->Pasajeros_Consulta->Ocupacion) ? $array->NewDataSet->Pasajeros_Consulta->Ocupacion : '',
                    "FechaNacimiento" => !is_object($array->NewDataSet->Pasajeros_Consulta->FecNacimiento) ? $array->NewDataSet->Pasajeros_Consulta->FecNacimiento : '', 
                    "Sexo" => !is_object($array->NewDataSet->Pasajeros_Consulta->Sexo) ? $array->NewDataSet->Pasajeros_Consulta->Sexo : '', 
                    "Nacionalidad" => !is_object($array->NewDataSet->Pasajeros_Consulta->PasNac) ? $array->NewDataSet->Pasajeros_Consulta->PasNac : '', 
                    "PaisResidencia" => !is_object($array->NewDataSet->Pasajeros_Consulta->PaisResidencia) ? $array->NewDataSet->Pasajeros_Consulta->PaisResidencia : '', 
                    "Telefono" => !is_object($array->NewDataSet->Pasajeros_Consulta->Telefono) ? $array->NewDataSet->Pasajeros_Consulta->Telefono : ''
                ];

                $catastrado = true;

                foreach($objeto as $data){
                    if(empty($data)){
                        $catastrado = false;
                    }   
                }


                $response = [
                    "error" => false,
                    "message" => "Datos del pasajero",
                    "message_user" => "Datos del pasajero",
                    "catastrado" => $catastrado,
                    "data" => $objeto
                ];

                return $response;

            } else {

                $response = [
                    "error" => true,
                    "message" => "No hay datos del pasajero",
                    "message_user" => "No hay datos del pasajero",
                    "data" => null
                ];

                return $response;
            }
        } catch (Exception $e) {
            $response = [
                "error" => true,
                "message" => $e->getMessage(),
                "message_user" => "No se pudo obtener datos del pasajero"
            ];

            return $response;
        }
    }
}