<?php

namespace App\Models\mssql;

use App\Models\CtlItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SGAUDetalleSolicitud extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';

    protected $table = 'SGAU_DetalleSolicitudCompra';

    protected $primaryKey = 'idDetalleSolicitud';
    

    protected $fillable = [
        'idSolicitudCompra',
        'idEspecifico',
        'CODI_ITEM',
        'descripcion',
        'especificacion',
        'justificacion',
        'cantidad',
        'precio',
        'monto',
        'fhIngreso',
        'fhUltimaModificacion',
        'usuarioModifica',
        'usuarioIngresa',
        'item_id',
        'measure_unit_id',
        'idProyecto'
    ];

    public function request()
    {
        return $this->belongsTo(SGAUSolicitudCompra::class, 'idSolicitudCompra', 'idSolicitudCompra');
    }

    public function getItem(){
        return $this->belongsTo(CtlItem::class, 'item_id', 'id');
    }




}
