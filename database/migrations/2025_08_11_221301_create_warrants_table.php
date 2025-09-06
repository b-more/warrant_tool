<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('warrants', function (Blueprint $table) {
            $table->id();
            $table->string('warrant_number')->unique()->nullable();
            $table->string('officer_name')->nullable();
            $table->string('station')->nullable();
            $table->json('phone_numbers')->nullable(); // Store multiple phone numbers
            $table->string('suspect_name')->nullable();
            $table->text('description')->nullable();
            $table->date('period_from')->nullable();
            $table->date('period_to')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed'])->default('pending')->nullable();
            $table->string('cdr_file_path')->nullable();
            $table->string('kyc_file_path')->nullable();

            // Add user relationship using unsignedBigInteger
            $table->unsignedBigInteger('user_id')->nullable();
            $table->index('user_id'); // Add index for performance

            // Add other potential foreign keys using unsignedBigInteger
            $table->unsignedBigInteger('case_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('warrants');
    }
};
