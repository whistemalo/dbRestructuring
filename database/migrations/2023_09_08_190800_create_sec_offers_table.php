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
        Schema::create('sec_offers', function (Blueprint $table) {
            $table->id();
            // crea las columnas defeinidas en SecOffer
            $table->foreignId('id_process')->constrained('sec_processes');
            $table->foreignId('id_bidder')->constrained('ctl_bidders');
            $table->decimal('amount_offered', 10, 2);
            $table->foreignId('id_status')->constrained('ctl_process_statuses');
            $table->timestamps();
            $table->softDeletes();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sec_offers');
    }
};
