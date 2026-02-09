<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // تغيير نوع العمود من enum إلى string لدعم أنواع وثائق إضافية
        DB::statement("ALTER TABLE documents MODIFY COLUMN type VARCHAR(50)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE documents MODIFY COLUMN type ENUM('birth_certificate', 'death_certificate', 'custody_certificate')");
    }
};
