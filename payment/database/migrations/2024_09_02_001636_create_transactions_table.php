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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('wallet_id')->references('id')->on('wallets');
            $table->enum('type',['deposit','withdraw','transfer','payment']);
            $table->integer('amount');
            $table->dateTime('date');
            $table->string('description')->nullable();
            $table->foreignUuid('recipient_wallet_id')->nullable()->references('id')->on('wallets');
            $table->enum('status',['pending','completed','failed']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
