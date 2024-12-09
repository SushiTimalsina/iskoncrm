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
        Schema::create('guest_take_cares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('devotee_id');
            $table->foreign('devotee_id')->references('id')->on('devotees')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('guest_take_cares');
    }
};
