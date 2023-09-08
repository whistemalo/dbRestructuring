<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Timestamp;

    protected  $table = 'sec_requests';

    public  $timestamps = true;

    protected  $primaryKey = 'id';

    protected  $keyType = 'int';

    protected  $softDelete = true;

    protected $fillable = [
        'id_project',
        'id_request_type',
        'id_employee',
        'destination',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    

}
