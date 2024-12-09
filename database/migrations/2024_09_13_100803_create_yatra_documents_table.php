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
        Schema::create('yatra_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('devotee_id');
            $table->foreign('devotee_id')->references('id')->on('devotees')->onDelete('cascade');
            $table->unsignedBigInteger('yatra_id')->nullable();
            $table->foreign('yatra_id')->references('id')->on('yatra_categories')->onDelete('cascade');
            $table->unsignedBigInteger('yatra_seasons_id')->nullable();
            $table->foreign('yatra_seasons_id')->references('id')->on('yatra_seasons')->onDelete('cascade');
            $table->string('type');
            $table->string('file');
            $table->unsignedBigInteger('createdby');
            $table->foreign('createdby')->references('id')->on('admins')->onDelete('cascade');
            $table->unsignedBigInteger('updatedby')->nullable();
            $table->foreign('updatedby')->references('id')->on('admins')->onDelete('cascade');
            $table->unsignedBigInteger('batch_id');
            $table->foreign('batch_id')->references('id')->on('course_batches')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yatra_documents');
    }
};
