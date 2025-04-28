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
        Schema::create('generated_pay_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payslip_id')->references('id')->on('payslip_structures')->onDelete('cascade');
            $table->string('payslip_name'); // Name of the payslip
            $table->string('employee_name'); // Employee name (first name)
            $table->decimal('base_salary', 10, 2); // Base salary
            $table->decimal('allowance', 10, 2)->nullable(); // Allowance (optional)
            $table->decimal('deduction', 10, 2)->nullable(); // Deduction (optional)
            $table->decimal('pf_contribution', 10, 2)->nullable(); // PF contribution (optional)
            $table->decimal('net_salary', 10, 2); // Net salary
            $table->integer('total_working_hours')->nullable(); // Total working hours
            $table->integer('total_overtime_hours')->nullable(); // Total overtime hours
            $table->date('start_date'); // Start date
            $table->date('end_date'); // End date
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generated_pay_slips');
    }
};
