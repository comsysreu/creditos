<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Creditos;

class CreditosController extends Controller
{
    public $statusCode  = 200;
    public $result      = false;
    public $message     = "";
    public $records     = [];

    public function index()
    {
        try {
            $registros = Creditos::all()

            if( $registros ) 
            {
                $this->statusCode   = 200;
                $this->result       = true;
                $this->message      = "Registros consultados exitosamente";
                $this->records      = $registros;  
            }
            else
                throw new \Exception("No se encontraron registros");
                
            
        } catch (\Exception $e) {
            $this->statusCode   = 200
            $this->result       = false;  
            $this->message      = env('APP_DEBUG') ? $e->getMessage() : "Ocurrió un problema al consultar los registros"; 
        }
        finally
        {
            $response = [
                'result'    => $this->result,
                'message'   => $this->message,
                'records'   => $this->records,
            ];

            return response()->json($response, $this->statusCode);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $nuevoRegistro = \DB::transaction( function() use ($request){
                                $nuevoRegistro = Creditos::create([
                                                    'clientes_id'           => $request->input('idcliente'),
                                                    'planes_id'             => $request->input('idplan'),
                                                    'montos_prestamos_id'   => $request->input('monto'),
                                                    'usuario_creo'          => $request->input('idusuario'),
                                                    'usuario_cobrador'      => $request->input('idusuario'),
                                                    'saldo'                 => $request->input('monto'),
                                                    'interes'               => 0,
                                                    'cuota_diaria'          => $request->input('cuota_diaria'),
                                                    'cuota_minima'          => $request->input('cuota_minima'),
                                                    'estado'                => 1,
                                                ]);

                                if( !$nuevoRegistro )
                                    throw new \Exception("Error al crear el registro");
                                else
                                    return $nuevoRegistro;
                            });

            $this->statusCode   = 200;
            $this->result       = true;
            $this->message      = "Registro creado exitosamente";
            $this->records      = $nuevoRegistro;
                
        } 
        catch (\Exception $e) 
        {
            $this->statusCode   = 200;
            $this->result       = false;
            $this->message      = env('APP_DEBUG') ? $e->getMessage() : "Ocurrió un problema al crear el registro";
        }
        finally
        {
            $response = [
                'result'    => $this->result,
                'message'   => $this->message,
                'records'   => $this->records,
            ];

            return response()->json($response, $this->statusCode);
        }
    }

    public function show($id)
    {
        try {
            $registro = Creditos::find( $id );

            if ( $registro ) {
                $this->statusCode   = 200;
                $this->result       = true;
                $this->message      = "Registro consultado exitosamente";
                $this->records      = $registro;
            }
            else
                throw new \Exception("Error al consultar el registro");
                
        } catch (\Exception $e) {
            $this->statusCode   = 200;
            $this->result       = false;
            $this->message      = env('APP_DEBUG') ? $e->getMessage() : "Ocurrió un problema al consultar el registro";
        }
        finally
        {
            $response = [
                'result'    => $this->result,
                'message'   => $this->message,
                'records'   => $this->records,
            ];

            return response()->json($response, $this->statusCode);
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        //
    }
}
