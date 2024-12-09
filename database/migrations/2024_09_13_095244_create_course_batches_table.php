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
        Schema::create('course_batches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('facilitators_id');
            $table->foreign('facilitators_id')->references('id')->on('course_facilitators')->onDelete('cascade');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->string('certificate')->nullable();
            $table->integer('fullmarks')->nullable();
            $table->string('examtype')->nullable();
            $table->integer('fee')->nullable();
            $table->string('unitdays')->nullable();
            $table->string('unit')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('type');
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
        Schema::dropIfExists('course_batches');
    }
};
