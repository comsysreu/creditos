<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Clientes;

class ClientesController extends Controller
{
    public $statusCode  = 200;
    public $result      = false;
    public $message     = "";
    public $records     = [];

    public function index()
    {
        try {
            $registros = Clientes::with('referenciasPersonales','creditos')->get();

            if( $registros ){
                $this->statusCode   = 200;
                $this->result       = true;
                $this->message      = "Registros consultados exitosamente";
                $this->records      = $registros;
            }
            else
                throw new \Exception("No se encontraron registros");
                
        } catch (\Exception $e) {
            $this->statusCode   = 200;
            $this->result       = false;
            $this->message      = env('APP_DEBUG') ? $e->getMessage() : "Ocurrió un problema al consultar los registros";
        }
        finally{
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
            $nuevoRegistro = \DB::transaction( function() use ( $request){
                                $nuevoRegistro = Clientes::create([
                                                    'nombre'        => $request->input('nombre'),
                                                    'apellido'      => $request->input('apellido'),
                                                    'dpi'           => $request->input('dpi'),
                                                    'telefono'      => $request->input('telefono'),
                                                    'estado_civil'  => $request->input('estadocivil'),
                                                    'sexo'          => $request->input('sexo'),
                                                    'categoria'     => $request->input('categoria'),
                                                    'color'         => $request->input('color'),
                                                ]);

                                if( !$nuevoRegistro )
                                    throw new \Exception("No se pudo crear el registro");
                                else
                                    return $nuevoRegistro;
                            });

            $this->statusCode   = 200;
            $this->result       = true;
            $this->message      = "Registro creado exitosamente";
            $this->records      = $nuevoRegistro;

        } catch (\Exception $e) {
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
            $registro = Clientes::find( $id );

            if( $registro ){
                $this->statusCode   = 200;
                $this->result       = true;
                $this->message      = "Registro consultado exitosamente";
                $this->records      = $registro;
            }
            else
                throw new \Exception("No se encontró el registro");
                
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
        try {
            \DB::beginTransaction();
            $registro = Clientes::find( $id );
            $registro->nombre       = $request->input('nombre', $registro->nombre);
            $registro->apellido     = $request->input('apellido', $registro->apellido);
            $registro->dpi          = $request->input('dpi', $registro->dpi);
            $registro->telefono     = $request->input('telefono', $registro->telefono);
            $registro->estado_civil = $request->input('estadocivil', $registro->estado_civil);
            $registro->sexo         = $request->input('sexo', $registro->sexo);
            $registro->categoria    = $request->input('categoria', $registro->categoria);
            $registro->color        = $request->input('color', $registro->color);
            $registro->save();

            \DB::commit();
            $this->statusCode   = 200;
            $this->result       = true;
            $this->message      = "Registro editado exitosamente";
            $this->records      = $registro;
                
        } catch (\Exception $e) {
            \DB::rollback();
            $this->statusCode   = 200;
            $this->result       = false;
            $this->message      = env('APP_DEBUG') ? $e->getMessage() : "Ocurrió un problema al editar el registro";
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

    
    public function destroy($id)
    {
        try {
            $deleteRegistro = \DB::transaction( function() use ( $id ){
                                $registro = Clientes::find( $id );
                                $registro->delete();
                            });

            $this->statusCode   = 200;
            $this->result       = true;
            $this->message      = "Registro eliminado exitosamente";
            
        } catch (\Exception $e) {
            $this->statusCode   = 200;
            $this->result       = false;
            $this->message      = env('APP_DEBUG') ? $e->getMessage() : "Ocurrió un problema al eliminar el registro";
        }
        finally
        {
            $response = [
                'result'    => $this->result,
                'message'   => $this->message,
            ];

            return response()->json($response, $this->statusCode);
        }
    }
}
