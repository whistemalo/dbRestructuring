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
            $table->foreignId('id_project')->constrained('ctl_projects');
            $table->string('id_request_type');
            $table->foreignId('id_employee')->constrained('mnt_employees');
            $table->string('destination');
            $table->timestamps();
            $table->softDeletes();
        });

        // add column to sec_request
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sec_requests');
    }
};
