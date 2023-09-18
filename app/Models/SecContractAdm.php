<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecContractAdm extends Model
{
    use HasFactory;
    use Timestamp;
    use SoftDeletes;

    protected $table = 'sec_po_adms';

    protected $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $softDelete = true;

    // fillable fields:
    // id_purchase_order, delivery_place, id_role, id_area
    protected $fillable = [
        'id_purchase_order',
        'id_role',
        'id_area',
        'delivery_place',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
