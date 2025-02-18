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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('asaas_id')->nullable();
            $table->enum('payment_method', ['boleto', 'cartao', 'pix']);
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('PENDING');
            $table->text('boleto_url')->nullable();
            $table->text('pix_qrcode')->nullable();
            $table->text('pix_copy')->nullable();
            $table->dateTime('expirationDatePix')->nullable();
            $table->string('customer_id');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_cpf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
