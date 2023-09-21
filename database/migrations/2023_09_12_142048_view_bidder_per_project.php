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
  
        DB::statement('CREATE OR REPLACE VIEW public.bidder_per_project
            AS
            SELECT 
            DISTINCT so.id AS id_offer,
           max( sp.id) as id_process,
           max( cp.id) AS id_project,
           max( cb.id) AS id_bidder,
           max( cb.name) AS bidder_name,
            so.amount_offered 
            FROM sec_requests sr
             JOIN ctl_projects cp ON cp.id = sr.id_project
             JOIN sec_processes sp ON sp.id = sr.id_process
             JOIN sec_offers so ON so.id_process = sp.id
             JOIN ctl_bidders cb ON cb.id = so.id_bidder
             GROUP BY so.id
            ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //elimina la vista
        DB::statement('DROP VIEW IF EXISTS public.bidder_per_project;');
    }
};
