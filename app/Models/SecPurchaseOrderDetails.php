<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecPurchaseOrderDetails extends Model
{
    use HasFactory;
    use Timestamp;
    use SoftDeletes;

    protected $table = 'sec_purchase_order_details';

    protected $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $softDelete = true;

    protected $fillable = [
        'id_purchase_order',
        'id_item',
        'quantity',
        'unit_price',
        'total',
        'description',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
  
    ];
}
