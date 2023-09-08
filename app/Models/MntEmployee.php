<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MntEmployee extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Timestamp;

    protected $table = 'mnt_employees';

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'id_status',
        'id_role',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

  


    
}
