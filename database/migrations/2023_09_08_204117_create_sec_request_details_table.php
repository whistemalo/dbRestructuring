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
        Schema::create('sec_request_details', function (Blueprint $table) {
            $table->id();
            // crea las columnas defeinidas en SecRequestDetails
            $table->foreignId('id_request')->constrained('sec_requests');
            $table->foreignId('id_item')->constrained('ctl_items');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->foreignId('id_measure_unit')->constrained('ctl_measure_units');
            $table->string('description', 1024)->nullable();
            $table->string('specifications', 1024)->nullable();
            $table->string('justification', 1024)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // a la tabla sec_offer_details agregale una llave foranea llamada id_request_details
        Schema::table('sec_offer_details', function (Blueprint $table) {
            $table->foreignId('id_request_details')->constrained('sec_request_details');
        });
        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        // elimina la llave foranea id_request_details de la tabla sec_offer_details
        Schema::table('sec_offer_details', function (Blueprint $table) {
            $table->dropForeign(['id_request_details']);
        });


        Schema::dropIfExists('sec_request_details');
    }
};
