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
        Schema::table('users', function (Blueprint $table) {
          $table->unsignedBigInteger('branch_id')->nullable();
          $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
          $table->unsignedBigInteger('devotee_id')->unique()->nullable();
          $table->foreign('devotee_id')->references('id')->on('devotees')->onDelete('cascade');
          $table->unsignedBigInteger('createdby')->nullable();
          $table->foreign('createdby')->references('id')->on('admins')->onDelete('cascade');
          $table->unsignedBigInteger('updatedby')->nullable();
          $table->foreign('updatedby')->references('id')->on('admins')->onDelete('cascade');
          $table->string('loginip')->nullable();
          $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('loginip');
        });
    }
};
