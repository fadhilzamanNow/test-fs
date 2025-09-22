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
       Schema::create('production_plans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->string("plan_name");

            // enum: pending, approved, rejected
            $table->enum('status', ['pending','approved','rejected'])->default('pending');

            $table->date('due_date');
            $table->timestamp('created_at');

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->cascadeOnDelete();


                   $table->uuid('created_by')->after('product_id');

            $table->foreign('created_by')
                  ->references('id')->on('users')
                  ->cascadeOnDelete();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_plans');
    }
};
