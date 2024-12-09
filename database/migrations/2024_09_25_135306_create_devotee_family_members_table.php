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
        Schema::create('devotee_family_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('devotees_id');
            $table->foreign('devotees_id')->references('id')->on('devotees')->onDelete('cascade');
            $table->unsignedBigInteger('devotee_id')->unique();
            $table->foreign('devotee_id')->references('id')->on('devotees')->onDelete('cascade');
            $table->string('role');
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
        Schema::dropIfExists('devotee_family_members');
    }
};
