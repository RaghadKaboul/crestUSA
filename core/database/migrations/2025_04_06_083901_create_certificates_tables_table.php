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
        Schema::create('certificates_tables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('certificate_number');
            $table->string('certificate_holders_name');
            $table->date('releas_date');
            $table->date('Expiry_date')->nullable();
            $table->string('Issuing_authority');
            $table->enum('status', ['معتمدة', 'غير معتمدة', 'منتهية الصلاحية'])->default('معتمدة');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates_tables');
    }
};
