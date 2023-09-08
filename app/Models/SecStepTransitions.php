<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecStepTransitions extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Timestamp;

    protected $table = 'sec_step_transitions';

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $softDelete = true;

    protected $fillable = [
        'id_process',
        'from_state',
        'to_state',
        'start_time',
        'end_time',
        'time_taken_in_seconds',
        'time_taken',
        'created_by'

    ];


}
