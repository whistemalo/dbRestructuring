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
        Schema::create('sec_processes', function (Blueprint $table) {
            $table->id();
            // crea las columnas defeinidas en SecProcess
            // $table->foreignId('id_project')->constrained('ctl_projects');
            $table->foreignId('id_status')->constrained('ctl_process_statuses');
            $table->foreignId('id_employee')->constrained('mnt_employees');
            // $table->foreignId('id_request')->constrained('sec_requests');
            $table->timestamps();
            $table->softDeletes();
        });

        // alter table sec_step_transitions add a foreing key
             // agrega la llave foranea del genero a la tabla de mnt_pacientes
             Schema::table('sec_step_transitions', function (Blueprint $table) {
                $table->foreignId('id_process')->constrained('sec_processes');
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sec_step_transitions', function (Blueprint $table) {
            $table->dropForeign(['id_process']);
        });
        Schema::dropIfExists('sec_processes');
    }
};
