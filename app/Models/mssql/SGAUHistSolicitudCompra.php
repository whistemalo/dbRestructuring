<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SGAUHistSolicitudCompra extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';

    protected $table = 'SGAU_HistSolicitudCompra';

    protected $primaryKey = 'idHistorico';

    // disable timestamps created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'idSolicitudCompra',
        'idEstatusSolicitud',
        'observacion',
        'fhCambio',
        'usuarioIngresa',
        'fhIngreso',
        'usuarioModifica',
        'fhUltimaModificacion',
        'fhInicioEstimado',
        'fhFinEstimado',
        'fhFin',
        'fhInicio',
    ];
}
