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
        Schema::create('orphans', function (Blueprint $table) {
            $table->id();
            $table->string('file_number')->unique();      // رقم الملف (تلقائي: AMC-YYYY-XXXX)
            $table->string('full_name');                  // الاسم الرباعي
            $table->string('national_id');                // رقم الهوية
            $table->date('birth_date');                   // تاريخ الميلاد
            $table->enum('gender', ['male', 'female']);   // الجنس
            $table->string('social_status');              // الحالة الاجتماعية
            $table->string('photo')->nullable();          // الصورة الشخصية
            $table->text('notes')->nullable();            // ملاحظات عامة
            $table->date('registration_date');            // تاريخ التسجيل
            $table->date('approval_date')->nullable();    // تاريخ الاعتماد
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orphans');
    }
};
