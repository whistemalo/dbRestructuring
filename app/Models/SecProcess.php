<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecProcess extends Model
{
    use HasFactory;
    use Timestamp;
    use SoftDeletes;

    protected $table = 'sec_processes';

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $softDelete = true;

    protected $fillable = [
        'id_status',
        'id_employee',
        // 'id_request',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    public function offers()
    {
        // return $this->hasMany(SecOffer::class, 'id_process', 'id')->with('bidder')->with('offerDetails');
        return $this->hasMany(SecOffer::class, 'id_process', 'id')->with('bidder');
    }




}
