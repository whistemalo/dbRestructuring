<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sec_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_project')
                    ->nullable()
            ->constrained('ctl_projects');
            $table->string('id_request_type');
            $table->foreignId('created_by')->constrained('mnt_employees');
            $table->foreignId('updated_by')->nullable()->constrained('mnt_employees');
            $table->foreignId('deleted_by')->nullable()->constrained('mnt_employees');
            $table->foreignId('id_process')
                    ->nullable()
                    ->constrained('sec_processes');
            $table->foreignId('id_request_status')->constrained('ctl_request_statuses');
            $table->string('destination');
            $table->timestamps();
            $table->softDeletes();
        });

        // Schema::table('sec_processes', function (Blueprint $table) {
        //     $table->foreignId('id_request')->constrained('sec_requests');
        // });
        
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    //     Schema::table('sec_processes', function (Blueprint $table) {
    //         $table->dropForeign(['id_solicitud']);
    //     });
        Schema::dropIfExists('sec_requests');
        
    }

};
