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
        Schema::create('sec_step_transitions', function (Blueprint $table) {
            $table->id();
            // $table->integer('id_process');
            $table->foreignId('from_state')->constrained('ctl_process_statuses');
            $table->foreignId('to_state')->constrained('ctl_process_statuses');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('time_taken_in_seconds');
            $table->string('time_taken');
            $table->foreignId('created_by')->constrained('mnt_employees');
           
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sec_step_transitions');
    }
};
