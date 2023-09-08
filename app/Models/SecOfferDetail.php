<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecOfferDetail extends Model
{
    use HasFactory;
    use Timestamp;
    use SoftDeletes;

    protected $table = 'sec_offer_details';

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $softDelete = true;

    protected $fillable = [
        'id_offer',
        'id_item',
        'quantity',
        'unit_price',
        'total_price',
        'id_measure_unit',
        'original_quantity',
        'created_at',
        'updated_at',
        'deleted_at'   
    ];
}
