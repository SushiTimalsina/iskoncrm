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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('devotee_id')->nullable();
            $table->foreign('devotee_id')->references('id')->on('devotees')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('sewa_id')->nullable();
            $table->foreign('sewa_id')->references('id')->on('sewas')->onDelete('cascade');
            $table->unsignedBigInteger('yatra_seasons_id')->nullable();
            $table->foreign('yatra_seasons_id')->references('id')->on('yatra_seasons')->onDelete('cascade');
            $table->unsignedBigInteger('course_batch_id')->nullable();
            $table->foreign('course_batch_id')->references('id')->on('course_batches')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('donation')->nullable();
            $table->string('donationtype')->nullable();
            $table->string('voucher')->nullable();
            $table->string('status');
            $table->unsignedBigInteger('createdby');
            $table->foreign('createdby')->references('id')->on('admins')->onDelete('cascade');
            $table->unsignedBigInteger('updatedby')->nullable();
            $table->foreign('updatedby')->references('id')->on('admins')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
