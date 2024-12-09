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
        Schema::create('devotees', function (Blueprint $table) {
            $table->id();
            $table->text('firstname');
            $table->text('middlename')->nullable();
            $table->text('surname')->nullable();
            $table->string('gotra')->nullable();
            $table->string('email')->unique()->nullable();
            $table->text('email_enc')->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->text('mobile_enc')->nullable();
            $table->text('phone')->nullable();
            $table->text('identitytype')->nullable();
            $table->string('identityid')->unique()->nullable();
            $table->text('identityid_enc')->nullable();
            $table->string('identityimage')->nullable();
            $table->text('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('bloodgroup')->nullable();
            $table->string('education')->nullable();
            $table->string('occupation')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->text('ptole')->nullable();
            $table->text('pwardno')->nullable();
            $table->text('pmuni')->nullable();
            $table->text('pdistrict')->nullable();
            $table->text('pprovince')->nullable();
            $table->text('ttole')->nullable();
            $table->text('twardno')->nullable();
            $table->text('tmuni')->nullable();
            $table->text('tdistrict')->nullable();
            $table->text('tprovince')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('nationality')->nullable();
            $table->unsignedBigInteger('occupations')->nullable();
            $table->foreign('occupations')->references('id')->on('occupations');
            $table->unsignedBigInteger('createdby');
            $table->foreign('createdby')->references('id')->on('admins')->onDelete('cascade');
            $table->unsignedBigInteger('updatedby')->nullable();
            $table->foreign('updatedby')->references('id')->on('admins')->onDelete('cascade');
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devotees');
    }
};
