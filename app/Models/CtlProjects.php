<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtlProjects extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTimestamps;

    protected $table = 'ctl_projects';

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $softDelete = true;

    protected $fillable = [
        'name',
        'code'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
