<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إنشاء مستخدم Admin
        User::firstOrCreate(
            ['email' => 'admin@alamal.org'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // إنشاء مستخدم Viewer للاختبار
        User::firstOrCreate(
            ['email' => 'viewer@alamal.org'],
            [
                'name' => 'متطلع على البيانات',
                'password' => Hash::make('viewer123'),
                'role' => 'viewer',
            ]
        );
    }
}
