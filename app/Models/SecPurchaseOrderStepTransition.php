<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecPurchaseOrderStepTransition extends Model
{
    use HasFactory;
    use Timestamp;
    use SoftDeletes;

    protected $table = 'sec_purchase_order_step_transitions';

    protected $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $softDelete = true;


    protected $fillable = [
        'id_purchase_order',
        'from_state',
        'to_state',
        'start_time',
        'end_time',
        'time_taken_in_seconds',
        'time_taken',
        'created_by'
    ];
}
