<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('post_id');
            $table->uuid('organisation_unit_id');
            $table->string('posting_type')->default('permanent');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('organisation_unit_id')->references('id')->on('organisation_units')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('postings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['post_id']);
            $table->dropForeign(['organisation_unit_id']);
        });

        Schema::dropIfExists('postings');
    }
};
