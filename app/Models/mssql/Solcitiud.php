<?php

namespace App\Models\mssql;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solcitiud extends Model
{
    use HasFactory;
    
    protected $connection = 'sqlsrv2';

    protected $table = 'SGAU_SolicitudCompra';

    protected $fillable = [
        'idSolicitudCompra',
        'CODI_EMPL',
        'CODI_FUEN_FINA',
        'CODI_CONV_FINA',
        'CODI_ORGA',
        'idEstatusSolicitud',
        'idTecnicoACI',
        'idTipoSolicitud',
        'idDestinoAdquisicion',
        'observacion',
        'usuarioIngresa',
        'fhIngreso',
        'usuarioModifica',
        'fhUltimaModificacion',
        'periodo',
        'fhInicio',
        'fhFin',
        'fhInicioEstimado',
        'fhFinEstimado',
        'jefeAutoriza',
        'idTipoEvento',
        'idProceso',
        'idProcesoAdq',
        'correlativoPeriodo',
        'idClasificacionProceso',
        'idProyecto',
        'fechaRecepcionPresupuesto',    
    ];
}
