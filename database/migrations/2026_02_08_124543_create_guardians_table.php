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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orphan_id')->constrained()->onDelete('cascade');
            $table->string('full_name');                  // الاسم الكامل
            $table->string('relationship');               // صلة القرابة
            $table->string('national_id')->nullable();    // رقم الهوية
            $table->string('phone')->nullable();          // رقم التواصل
            $table->string('address')->nullable();        // مكان السكن
            $table->date('father_death_date')->nullable();// تاريخ وفاة الأب
            $table->string('death_cause')->nullable();    // سبب الوفاة
            $table->text('social_economic_status')->nullable(); // الوضع الاجتماعي والاقتصادي
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
