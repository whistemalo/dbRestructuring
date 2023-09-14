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
        Schema::create('sec_purchase_order_step_transitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_purchase_order')->constrained('sec_purchase_orders')->comment('Orden de compra a la que se le realiza la transicion de estado.');
            $table->foreignId('from_state')->constrained('mnt_purchase_order_statuses')->comment('Estado desde el que se realiza la transicion.');
            $table->foreignId('to_state')->constrained('mnt_purchase_order_statuses')->comment('Estado hacia el que se realiza la transicion.');
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
        Schema::dropIfExists('sec_purchase_order_step_transitions');
    }
};
