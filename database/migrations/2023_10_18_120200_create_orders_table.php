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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_of_delivery')
                ->references('id')
                ->on('type_of_delivery')
                ->onDelete('cascade');
            $table->foreignId('address')
                ->references('id')
                ->on('address')
                ->onDelete('cascade');
            $table->boolean('pay_online');
            $table->foreignId('invoice_id')
                ->references('id')
                ->on('invoices')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
