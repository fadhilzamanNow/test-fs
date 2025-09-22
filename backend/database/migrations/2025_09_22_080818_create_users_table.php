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
        Schema::create("users", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("username")->unique();
            $table->string("email")->unique();
            $table->string("password");
            $table->uuid("role_id");
            $table->uuid("module_id");


            $table->foreign("role_id")->references("id")->on("roles");
            $table->foreign("module_id")->references("id")->on("modules");
            $table->timestamp("created_at");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
