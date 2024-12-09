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
        Schema::create('sewa_sankalpas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guesttakecare_id');
            $table->foreign('guesttakecare_id')->references('id')->on('guest_take_cares')->onDelete('cascade');
            $table->unsignedBigInteger('devotee_id')->unique();
            $table->foreign('devotee_id')->references('id')->on('devotees')->onDelete('cascade');
            $table->unsignedBigInteger('sewa_id')->nullable();
            $table->foreign('sewa_id')->references('id')->on('sewas')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->string('amount')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('duration')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('createdby');
            $table->foreign('createdby')->references('id')->on('admins')->onDelete('cascade');
            $table->unsignedBigInteger('updatedby')->nullable();
            $table->foreign('updatedby')->references('id')->on('admins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewa_sankalpas');
    }
};
