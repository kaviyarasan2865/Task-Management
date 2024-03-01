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
        Schema::create('employee_details', function (Blueprint $table) {
            $table->id();
            $table->string('employeeName');
            $table->string('employeeMobile');
            $table->string('employeeEmail');
            $table->date('employeeDOB');
            $table->enum('employeeGender', ['Male', 'Female', 'Other']);
            $table->date('employeeDOJ');
            $table->string('employeeAddress');
            $table->string('employeePassword');
            $table->enum('employeeCategory', ['hr', 'developer', 'tester']);
            $table->string('employeeSubcategory')->nullable();
            $table->binary('employeeProfileImage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_details');
    }
};
