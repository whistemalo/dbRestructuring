<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\mssql\Solcitiud;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ActualizarEstado extends Controller
{

    public function ActualizarEstado(Request $request){

        $solicitudes =  Solcitiud::all();


        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente',
            'solicitudes' => $solicitudes,
        ], 200);



        // $id_request = $request->id_request;
        // $id_status = $request->id_status;   
        // $username = $request->username;

        // // $id_request = 5988;


        

        // $hist = [
        //     'idSolicitudCompra' => $id_request??2415,
        //     'idEstatusSolicitud' => $id_status,
        //     'observacion' => 'Aprobacion Gerencia Solicitante',
        //     'fhCambio' => Carbon::now(),
        //     'usuarioIngresa' => $username,
        //     'fhIngreso' => Carbon::now(),
        //     'usuarioModifica' => $username,
        //     'fhUltimaModificacion' => Carbon::now(),
        //     'fhInicioEstimado' => Carbon::now(),
        //     'fhFinEstimado' => Carbon::now()->addDay(),
        //     'fhFin' => Carbon::now()->addDay(),
        //     'fhInicio' => Carbon::now(),
        // ];

        // $data =[
        //     'update' => $hist
        // ];


        
        
        // $response = Http::post('192.168.0.228:3000/updateRequest', $data);



        
        
        
        
        
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Estado actualizado correctamente',
        //     'respuesta_expressjs' => $response->json(),
        // ], 200);   
    }
    
    
}

// llama a una api externa 
// $response = Http::post('192.168.0.228:3000/', [
//     'id_process' => $id_process,
//     'id_status' => $id_status,
//     'id_user' => $id_user,
// ]);