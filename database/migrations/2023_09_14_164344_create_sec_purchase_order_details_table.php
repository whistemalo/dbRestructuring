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
        Schema::create('sec_purchase_order_details', function (Blueprint $table) {
            $table->id();
            // usando los datos del fillable SecPurchaseOrderDetails crea las columnas
            $table->foreignId('id_purchase_order')->constrained('sec_purchase_orders');
            $table->foreignId('id_item')->constrained('ctl_items');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('description');
            $table->foreignId('updated_by')->constrained('mnt_employees');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sec_purchase_order_details');
    }
};
