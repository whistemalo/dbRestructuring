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
        Schema::create('sec_purchase_orders', function (Blueprint $table) {
            $table->id();
            // id_offer,id_status,created_at,emited_at,updated_at,deleted_at
            // tatal_po, payment_terms, other_terms,planned_delivery_date,delivery_place,delivery_time
            $table->foreignId('id_offer')->constrained('sec_offers')->comment('Oferta a la que se le genera la orden de compra.');
            $table->foreignId('id_po_status')->constrained('mnt_purchase_order_statuses')->comment('Estado de la orden de compra.');
            $table->foreignId('id_bidder')->constrained('ctl_bidders')->comment('Proveedor de la orden de compra.');
            $table->string('purchase_order_code')->nullable()->comment('Codigo de la orden de compra.');
            $table->decimal('total_po', 10, 2)->nullable()->comment('Total de la orden de compra.');

            $table->text('payment_terms')->nullable()->comment('Terminos de pago de la orden de compra.');
            $table->text('other_terms')->nullable()->comment('Otros terminos de la orden de compra.');


            $table->dateTime('planned_delivery_date')->nullable()->comment('Fecha de entrega planificada de la orden de compra.');
            $table->text('delivery_place')->nullable()->comment('Lugar de entrega de la orden de compra.');
            $table->text('delivery_time')->nullable()->comment('Tiempo de entrega de la orden de compra. Ej. 3 DIAS HABILIES');
            $table->dateTime('emited_at')->nullable()->comment('Fecha de emision de la orden de compra.');
            $table->foreignId('updated_by')->nullable()->constrained('mnt_employees')->comment('Empleado que actualiza la orden de compra.');
            $table->foreignId('emited_by')->nullable()->constrained('mnt_employees')->comment('Empleado que emite la orden de compra.');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sec_purchase_orders');
    }
};
