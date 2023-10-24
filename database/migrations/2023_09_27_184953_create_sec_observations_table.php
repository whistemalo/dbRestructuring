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
        Schema::create('sec_observations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_request')->constrained('sec_requests');
            $table->foreignId('created_by')->constrained('mnt_employees');
            $table->text('observation');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sec_observations');
    }
};
