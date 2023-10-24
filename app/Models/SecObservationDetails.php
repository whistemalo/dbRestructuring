<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecObservationDetails extends Model
{
    use HasFactory;
    use HasTimestamps;
    use SoftDeletes;

    protected  $table = 'sec_observations_details';

    public  $timestamps = true;

    protected  $primaryKey = 'id';

    protected  $keyType = 'int';

    protected  $softDelete = true;

    protected $fillable = [
        'id_observation',
        'id_request_detail_item',
        'comment'
    ];





}
