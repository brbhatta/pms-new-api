<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organisation_units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('type');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('type');

            $table->uuid('parent_id')->index()->nullable();
        });

        Schema::table('organisation_units', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('organisation_units')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('organisation_units', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });

        Schema::dropIfExists('organisation_units');
    }
};
