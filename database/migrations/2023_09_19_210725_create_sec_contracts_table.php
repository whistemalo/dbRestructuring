<?php

use App\Models\SecContracts;
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
        Schema::create('sec_contracts', function (Blueprint $table) {
            
            $table->id();
            // crea todas las columnas en base a $fillable de la clase SecContracts
            $table->foreignId('id_purchase_order')->nullable()->constrained('sec_purchase_orders')->comment('Orden de compra para la que se genera el contrato.');
            

            $table->string('contract_number')->nullable()->comment('Numero de contrato.');
            $table->string('tender_number')->nullable()->comment('Numero de licitacion.');
            $table->string('contract_description')->nullable()->comment('Descripcion del contrato.');
            $table->foreignId('id_bidder')->nullable()->constrained('ctl_bidders')->comment('Proveedor que gana la licitacion.');
            $table->date('contract_date')->nullable()->comment('Fecha de inicio del contrato.');
            $table->date('contract_deadline')->nullable()->comment('Fecha de vencimiento de contrato.');
            // $table->foreignId('id_contract_tipology')->nullable()->constrained('ctl_contract_tipologies')->comment('Tipologia de contrato.');
            $table->String('id_contract_tipology')->nullable()->comment('Tipologia de contrato.');
            $table->decimal('contract_amount', 18, 2)->nullable()->comment('Monto del contrato.');
            $table->string('contract_currency')->default('USD')->comment('Moneda del contrato.');
            $table->integer('term_contract')->nullable()->comment('Plazo del contrato.');
            $table->integer('extension_days')->nullable()->comment('Dias de extension del contrato.');
            $table->decimal('advance_percentage', 18, 2)->nullable()->comment('Porcentaje de anticipo.');
            $table->date('contract_signature_date')->nullable()->comment('Fecha de firma de contrato.');
            // $table->foreignId('id_contract_type')->nullable()->constrained('ctl_contract_types')->comment('Tipo de contrato.');
            $table->string('id_contract_type')->nullable()->comment('Tipo de contrato.');
            $table->foreignId('contract_admin')->nullable()->constrained('mnt_employees')->comment('Administrador del contrato.');
            // $table->foreignId('id_contract_status')->nullable()->constrained('ctl_contract_statuses')->comment('Estado del contrato.');
            $table->string('id_contract_status')->nullable()->comment('Estado del contrato.');
            // $table->foreignId('id_component')->nullable()->constrained('ctl_components')->comment('Componente del contrato.');
            $table->string('id_component')->nullable()->comment('Componente del contrato.');
            $table->string('accounting_period')->nullable()->comment('Periodo contable.');
            $table->boolean('manual_insert')->nullable()->comment('Indica si el contrato fue ingresado manualmente.');
            // $table->foreignId('id_contract_detail')->nullable()->constrained('sec_contract_details')->comment('Detalle del contrato.');
            $table->string('id_contract_detail')->nullable()->comment('Detalle del contrato.');
            $table->foreignId('created_by')->nullable()->constrained('mnt_employees')->comment('Usuario que registra el contrato.');
            $table->foreignId('updated_by')->nullable()->constrained('mnt_employees')->comment('Usuario que actualiza el contrato.');
            $table->foreignId('parent_contract')->nullable()->constrained('sec_contracts')->comment('Contrato padre.');
            $table->string('id_external_adm')->nullable()->comment('Usado en los proyectos heredados del FISDL.');
            $table->string('project_description')->nullable()->comment('Descripcion del proyecto.');
            $table->decimal('original_contracted_amount', 18, 2)->nullable()->comment('Monto original del contrato.');
            $table->date('contract_inital_date')->nullable()->comment('Fecha de inicio del contrato.');
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sec_contracts');
    }
};
