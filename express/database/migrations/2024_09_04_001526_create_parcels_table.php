<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name_product');
            $table->string('name_recipient');
            $table->string('address_shipper');
            $table->string('name_shipper');
            $table->string('address_recipient');
            $table->enum('status', ['pending', 'delivered', 'cancelled', 'shipped'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcels');
    }
};
