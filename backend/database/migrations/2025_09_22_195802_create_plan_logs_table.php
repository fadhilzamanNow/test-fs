<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plan_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('plan_id');
            $table->enum('from_status', ['pending','approved','rejected'])->nullable();
            $table->enum('to_status', ['pending','approved','rejected']);
            $table->uuid('changed_by')->nullable(); // link to user if needed
            $table->text('note')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('plan_id')->references('id')->on('production_plans')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_logs');
    }
};
