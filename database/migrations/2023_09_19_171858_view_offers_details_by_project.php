<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW view_offers_details_by_project AS
             with active_process as (
                     select 
                     sp.id as id_process,
                     sp.id_status ,
                     sr.id as id_request,
                     sr.id_project 
                     from sec_processes sp 
                     inner join sec_requests sr on sr.id_process = sp.id 
                     where sp.id_status in(12,19,20,7)
                     )
                     select
                     ap.id_project,
                     ap.id_process,
                     sod.*
                    
                     from sec_offers so 
                     inner join active_process ap on ap.id_process = so.id_process
                     inner join sec_offer_details sod on sod.id_offer  = so.id"
        );
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //borra la vista
        DB::statement("DROP VIEW IF EXISTS view_offers_details_by_project");
    }
};
