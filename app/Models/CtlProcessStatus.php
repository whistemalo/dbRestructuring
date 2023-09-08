<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtlProcessStatus extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Timestamp;

    protected $table = 'ctl_process_statuses';

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $softDelete = true;

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


}
