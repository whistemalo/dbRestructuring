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
        Schema::create('mnt_employees', function (Blueprint $table) {
            $table->id();
            $table->string('code_employee')->nullable();
            $table->string('name');
            $table->string('id_role')->nullable() ->comment('Cambiar esta columna para que use un id');
            $table->string('username')->nullable() ->comment('Nombre de usuario heredado de la tabla de EMPL');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mnt_employees');
    }
};
