<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MntPurchaseOrderStatuses extends Model
{
    use HasFactory;
    use Timestamp;
    use SoftDeletes;

    protected $table = 'mnt_purchase_order_statuses';

    protected $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $softDelete = true;

    // fillable fields:
    // name, description
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
