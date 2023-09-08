<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecOffer extends Model
{
    use HasFactory;
    use Timestamp;
    use SoftDeletes;

    protected $table = 'sec_offers';

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $softDelete = true;

    // fillable fields; id_process, id_bidder, amount_offered
    protected $fillable = [
        'id_process',
        'id_bidder',
        'amount_offered',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
