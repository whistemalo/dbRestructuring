<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecContracts extends Model
{
    use HasFactory;
    use Timestamp;
    use SoftDeletes;

    protected $table = 'sec_contracts';

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $softDelete = true;

    protected $fillable = [
        // cols nuevas
        'id_purchase_order',
        
        
        //cols base

        'contract_number',
        'tender_number',
        'contract_description',
        'id_bidder',
        'contract_date',
        'contract_deadline',
        'id_contract_tipology',
        'contract_amount',
        'contract_currency',
        'term_contract',
        'extension_days',
        'advance_percentage',
        'contract_signature_date',
        'id_contract_type',
        'contract_admin',
        'id_contract_status',
        'id_component',
        'accounting_period',
        'manual_insert',
        'id_contract_detail',
        'id_external_adm',
        'project_description',
        'original_contracted_amount',
        'contract_inital_date',
        'created_by',
        'updated_by',
        'parent_contract',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    

    
}
