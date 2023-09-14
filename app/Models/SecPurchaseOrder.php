<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecPurchaseOrder extends Model
{
    use HasFactory;
    use Timestamp;
    use SoftDeletes;

    protected $table = 'sec_purchase_orders';

    protected $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $softDelete = true;

    // fillable fields:
    // id_offer,id_status,created_at,emited_at,updated_at,deleted_at
    // tatal_po, payment_terms, other_terms,planned_delivery_date,delivery_place
    // delivery_time

    protected $fillable = [
        'id_offer',
        'id_status',
        'purchase_order_code',
        'id_bidder',
        'created_at',
        'emited_at',
        'updated_at',
        'deleted_at',
        'total_po',
        'payment_terms',
        'other_terms',
        'planned_delivery_date',
        'delivery_time',
        'delivery_place',
        'updated_by',
        'emited_by',
    ];
}
