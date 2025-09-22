<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('plan_id');   
            $table->enum('status', ['waiting', 'in_progress', 'done'])->default('waiting');
            $table->integer('actual_ok')->nullable();
            $table->integer('actual_ng')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamp('created_at');
            $table->foreign('plan_id')->references('id')->on('production_plans')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
