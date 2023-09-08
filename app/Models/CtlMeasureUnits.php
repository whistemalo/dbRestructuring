<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtlMeasureUnits extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTimestamps;

    // nombre de la tabla
    protected $table = 'ctl_measure_units';

    // timestamp
    public $timestamps = true;

    // llave primaria
    protected $primaryKey = 'id';

    // tipo de llave primaria
    protected $keyType = 'int';

    // soft delete
    protected $softDelete = true;
    

    // fillable
    protected $fillable = [
        'name',
        'code'
    ];

    // hidden
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
