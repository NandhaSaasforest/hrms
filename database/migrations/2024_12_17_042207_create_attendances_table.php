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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            // $table->foreignId('attendance_log_id')->nullable()->constrained('attendance_logs')->onDelete('cascade');

            $table->date('date')->required();
            $table->time('login_time')->required();
            $table->time('logout_time')->nullable();
            $table->boolean('status')->required()->default(false);
            $table->boolean('late_login')->default(false);
            $table->boolean('early_checkout')->default(false);
            $table->integer('total_working_hours');
            $table->integer('overtime_hours')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
