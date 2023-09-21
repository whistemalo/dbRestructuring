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
            CREATE OR REPLACE VIEW view_active_process_by_project AS
            SELECT 
            sp.id as id_process,
            sp.id_status ,
            sr.id as id_request,
            sr.id_project 
            FROM sec_processes sp 
            INNER JOIN sec_requests sr ON sr.id_process = sp.id 
            WHERE sp.id_status IN(12,19,20,7)
        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Eliminar la vista
        DB::statement("DROP VIEW IF EXISTS view_active_process_by_project");
    }
};
