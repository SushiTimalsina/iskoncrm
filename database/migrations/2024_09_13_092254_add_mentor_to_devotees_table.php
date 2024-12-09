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
        Schema::table('devotees', function (Blueprint $table) {
          $table->unsignedBigInteger('mentor')->nullable();
          $table->foreign('mentor')->references('id')->on('mentors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devotees', function (Blueprint $table) {
            //
        });
    }
};
