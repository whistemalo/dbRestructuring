<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Request\PendingRequestResource;
use App\Models\CtlRequestStatuses;
use App\Models\MntEmployee;
use App\Models\mssql\SGAUSolicitudCompra;
use App\Models\SecObservationDetails;
use App\Models\SecObservations;
use App\Models\SecRequest;
use App\Models\SGAUHistSolicitudCompra;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{

    public function getPendingRequestById($id_request){
        $puchaseRequests = SecRequest::where('id_request_status', '2')
        ->where('id_request_type', '5')
        ->where('id', $id_request)
        ->get();

        $puchaseRequests = PendingRequestResource::collection($puchaseRequests);

        return response()->json([
            'status' => 'success',
            'message' => 'Solicitudes pendientes',
            'data' => $puchaseRequests
        ], 200);    

    }


    public function getPendingRequests(){
        $puchaseRequests = SecRequest::where('id_request_status', '2')
        ->where('id_request_type', '5')
        ->get();

        $puchaseRequests = PendingRequestResource::collection($puchaseRequests);

        return response()->json([
            'status' => 'success',
            'message' => 'Solicitudes pendientes',
            'data' => $puchaseRequests
        ], 200);    

    }


    public function changeRequestStatus(Request $request){

        // get employee from the request with sanctum
        // $employee = $request->user();


        $request->validate([
            'id_request' => 'required',
            'id_request_status' => 'required',
            'comment' => 'required',
            // valida que venga un array de items
            'items' => 'required|array',
            'items.*.id_request_detail' => 'required|integer',
            'items.*.resolution' => 'required|integer',
               ]);


        $updated_at = now()->setTimezone('America/El_Salvador');
        $end_date = Carbon::now()->addDay()->setTimezone('America/El_Salvador');

        /* RESTRUCTURED DB */
        $purchaseRequest = SecRequest::find($request->id_request);
            $purchaseRequest->id_request_status = $request->id_request_status;
            $purchaseRequest->updated_by = $request->id_employee;
            $purchaseRequest->updated_at = $updated_at;
        

        // Observaciones
        $newObservation = new SecObservations();
            $newObservation->id_request = $request->id_request;
            $newObservation->created_by = $request->id_employee;
            $newObservation->observation = $request->comment;

        $arrItemObservations = $request->items;

      
        
        /********************* */
        /* FRAMEWORK 2 SYSTEM */
        $usuarioModifica= MntEmployee::find($request->id_employee)->only('username');
        $updateSolicitud = SGAUSolicitudCompra::find($request->id_request);
        $observacion = CtlRequestStatuses::find($updateSolicitud->idEstatusSolicitud)->only('name');

        $newHistorico = new SGAUHistSolicitudCompra();
            $newHistorico->idSolicitudCompra= $request->id_request;
            $newHistorico->idEstatusSolicitud= $request->id_request_status;
            $newHistorico->observacion= $observacion['name'];
            $newHistorico->fhCambio= $updated_at;
            $newHistorico->usuarioIngresa= $usuarioModifica['username'];
            $newHistorico->fhIngreso= $updated_at;
            $newHistorico->usuarioModifica= $usuarioModifica['username'];
            $newHistorico->fhUltimaModificacion= $updated_at;
            $newHistorico->fhInicioEstimado= $updated_at;
            $newHistorico->fhFinEstimado= $end_date;
            $newHistorico->fhInicio= $updated_at;

        /* update old solicitud */
        $updateSolicitud->idEstatusSolicitud = $request->id_request_status;
        $updateSolicitud->fhUltimaModificacion = $updated_at;
        $updateSolicitud->usuarioModifica = $usuarioModifica['username'];


        if($request->id_request_status == $updateSolicitud->idEstatusSolicitud){
            return response()->json([
                'status' => 'error',
                'message' => 'La solicitud ya se encuentra en este estado',
            ], 409);
        }
           
        



        
        

        try {
            DB::beginTransaction();
            $newId= SGAUHistSolicitudCompra::max('idHistorico');
            $newHistorico->idHistorico = $newId + 1;
            $newHistorico->save();
            $updateSolicitud->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar la solicitud',
                'error' => $th->getMessage()
            ], 500);
        }

        try {
            DB::beginTransaction();
            $newObservation->save();
            foreach ($arrItemObservations as $item) {
                $newObservationDetail = new SecObservationDetails();
                    $newObservationDetail->id_observation = $newObservation->id;
                    $newObservationDetail->id_request_detail_item = $item['id_request_detail'];
                    $newObservationDetail->comment = $item['resolution'];
                $newObservationDetail->save();
            }
            $purchaseRequest->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar la solicitud',
                'error' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Solicitud actualizada',
            'historico' => $observacion
        ], 200);    

    }





    // public function getPendingRequests(){
    //     $puchaseRequests = SecRequest::with('items:id_request,id_item,id_measure_unit,total_price,quantity,unit_price,description,specifications,justification')
    //     ->with('project:id,name,code')
    //     ->select('id','id_request_status','created_at','updated_at','id_project')
    //     ->where('id_request_status', '2')
    //     ->where('id_request_type', '5')
    //     ->get();

    //     $puchaseRequests = PendingRequestResource::collection($puchaseRequests);

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Solicitudes pendientes',
    //         'data' => $puchaseRequests
    //     ], 200);

    // }

    public function getRequestTrazability($id_request){
        $request = SecRequest::with('process')
                            ->with('items')
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
