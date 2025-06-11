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
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');

            $table->string('name');
            $table->string('email');
            $table->string('phone_number');

            $table->text('item_detail');
            $table->string('image')->nullable();

            // Status pesanan
            $table->enum('status', ['menunggu', 'dicek', 'proses', 'selesai', 'dikirim'])->default('menunggu');
            $table->string('tracking_code')->unique();

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
