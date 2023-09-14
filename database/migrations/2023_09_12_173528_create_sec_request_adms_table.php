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
        Schema::create('sec_request_adms', function (Blueprint $table) {
            $table->id();
            // // fillable fields; id_request,id_employee, delivery_place
            $table->foreignId('id_request')->constrained('sec_requests');
            $table->foreignId('id_employee')->constrained('mnt_employees');
            $table->string('delivery_place')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sec_request_adms');
    }
};
