<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecRequestAdm extends Model
{
    use HasFactory;
    use Timestamp;
    use SoftDeletes;

    protected $table = 'sec_request_adms';

    protected $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $softDelete = true;

    // fillable fields; id_request,id_employee, delivery_place
    protected $fillable = [
        'id_request',
        'id_employee',
        'delivery_place',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


}
