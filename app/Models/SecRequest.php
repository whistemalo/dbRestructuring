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
        'created_by',
        'updated_by',
        'deleted_by',
        'id_process',
        'id_request_status',
        'destination',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function createdBy()
    {
        return $this->belongsTo(MntEmployee::class, 'created_by', 'id');
    }


    public function items()
    {
        return $this->hasMany(SecRequestDetails::class, 'id_request', 'id')->with('item:id,name')->with('measureUnit:id,name');
    }

    public function project()
    {
        return $this->belongsTo(CtlProjects::class, 'id_project', 'id');
    }

    public function process()
    {
        return $this->belongsTo(SecProcess::class, 'id_process', 'id')->with('offers');
    }




    

}
