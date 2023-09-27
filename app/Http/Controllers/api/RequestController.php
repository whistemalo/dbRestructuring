<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Request\PendingRequestResource;
use App\Models\mssql\Solicitud;
use App\Models\SecRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{

    public function getPendingRequests(){
        $puchaseRequests = SecRequest::with('items:id_request,id_item,id_measure_unit,total_price,quantity,unit_price,description,specifications,justification')
        ->with('project:id,name,code')
        ->select('id','id_request_status','created_at','updated_at','id_project')
        ->where('id_request_status', '2')
        ->where('id_request_type', '5')
        ->get();

        $puchaseRequests = PendingRequestResource::collection($puchaseRequests);

        return response()->json([
            'status' => 'success',
            'message' => 'Solicitudes pendientes',
            'data' => $puchaseRequests
        ], 200);

    }

    public function getRequestTrazability($id_request){
        $request = SecRequest::
        with('process')->
                            with('items')
                            ->find($id_request);

        return response()->json([
            'status' => 'success',
            'message' => 'Solicitud',
            'data' => $request
        ], 200);

    }




    /** Get pending request from mssql */
    // public function getPendingRequests(Request $request)
    // {
    //     // trae todas las colitudes cone idEstatusSolicitud = 1,  fhIngreso en el 2023 y idTipoSolicitiud = 5
    //     $solicitudes = Solicitud::with('details')->where('idEstatusSolicitud', '1')->where('idTipoSolicitud', '5')
    //     ->select('idSolicitudCompra', 'idEstatusSolicitud', 'fhIngreso', 'idTipoSolicitud')->get();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Solicitudes pendientes',
    //         'data' => $solicitudes
    //     ], 200);       
    // }
}
