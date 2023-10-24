<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecObservations extends Model
{
    use HasFactory;
    use Timestamp;
    use SoftDeletes;

    protected  $table = 'sec_observations';

    public  $timestamps = true;

    protected  $primaryKey = 'id';

    protected  $keyType = 'int';

    protected  $softDelete = true;

    protected $fillable = [
        'id_request',
        'created_by',
        'observation',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
