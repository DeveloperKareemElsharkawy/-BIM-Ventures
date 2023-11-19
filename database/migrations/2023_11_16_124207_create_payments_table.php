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

            $table->foreignId('transaction_id')->constrained();
            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('set null');

            $table->decimal('amount');
            $table->date('paid_date');
            $table->text('details')->nullable();

            $table->timestamps();

            $table->index(['created_by', 'transaction_id']);

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
