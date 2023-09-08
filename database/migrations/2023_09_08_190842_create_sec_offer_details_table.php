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
        Schema::create('sec_offer_details', function (Blueprint $table) {
            $table->id();
            // crea las columnas defeinidas en SecOfferDetail
            $table->foreignId('id_offer')->constrained('sec_offers');
            $table->foreignId('id_item')->constrained('ctl_items');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->foreignId('id_measure_unit')->constrained('ctl_measure_units');
            $table->integer('original_quantity');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sec_offer_details');
    }
};
