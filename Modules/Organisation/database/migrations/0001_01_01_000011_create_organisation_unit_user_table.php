<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organisation_unit_user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organisation_unit_id');
            $table->uuid('user_id');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamps();

            $table->unique(['organisation_unit_id', 'user_id']);
            $table->foreign('organisation_unit_id')->references('id')->on('organisation_units')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organisation_unit_user');
    }
};
