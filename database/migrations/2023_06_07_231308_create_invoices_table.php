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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 255);
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('product', 255);
            $table->string('discount', 255);
            $table->decimal('amount_commission', 8, 2)->nullable();
            $table->decimal('amount_collection', 8, 2);
            $table->string('rate_vat', 255);
            $table->decimal('value_vat', 8, 2);
            $table->decimal('total', 8, 2);
            $table->string('status', 50);
            $table->integer('value_status');
            $table->text('notes')->nullable();
            $table->string('user', 255);
            $table->foreignId('section_id')->constrained()->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};