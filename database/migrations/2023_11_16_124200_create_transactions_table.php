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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained();
            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('set null');

            $table->decimal('amount');
            $table->date('due_date');
            $table->decimal('vat_percentage');
            $table->boolean('is_vat_inclusive');
            $table->enum('status', ['paid', 'outstanding', 'overdue'])->default('Outstanding');
            $table->timestamps();

            $table->index(['user_id', 'created_by']);
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
