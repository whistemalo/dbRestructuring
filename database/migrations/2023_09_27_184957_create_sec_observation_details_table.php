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
        Schema::create('sec_observation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_observation')->constrained('sec_observations');
            $table->foreignId('id_request_detail_item')->constrained('sec_request_details');
            $table->text('comment');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sec_observation_details');
    }
};
