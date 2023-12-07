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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_of_delivery_id')
                ->references('id')
                ->on('type_of_delivery')
                ->onDelete('cascade');
            $table->foreignId('address_id')
                ->references('id')
                ->on('address')
                ->onDelete('cascade');
            $table->enum('pay_type',['online','przelew','odbiór','raty'])->default('online');
            $table->integer('invoice_number');
            $table->foreignId('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->softDeletes();
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
