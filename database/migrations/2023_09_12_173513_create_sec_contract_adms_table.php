<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sec_po_adms', function (Blueprint $table) {
            $table->id()->comment('Esta tabla contiene los 
            administradores de los N contratos que genera un proceso a traves 
            de las X ofertas que se ingresan.');

            
            // esta columna se agrega en la migracion de sec_purchase_orders
            $table->foreignId('id_purchase_order')->constrained('sec_purchase_orders')->comment('Orden de compra a la que se asigna un administrador.');


            // $table->foreignId('id_role')->constrained('mnt_roles')->comment('Rol del empleado que se asigna como administrador del contrato.');
            $table->string('id_role')->nullable()->comment('Rol del empleado que se asigna como administrador del contrato.');


            // $table->foreignId('id_area')->constrained('mnt_areas')->comment('Area a la que pertenece el empleado que se asigna como administrador del contrato.');
            $table->string('id_area')->nullable()->comment('Area a la que pertenece el empleado que se asigna como administrador del contrato.');

            
            $table->string('delivery_place')->nullable()->comment('Lugar de entrega de la orden de compra.');
            $table->timestamps();
            $table->softDeletes();
            
        });

       

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sec_po_adms');
    }
};
