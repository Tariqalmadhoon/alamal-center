<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrphanController;
use App\Http\Controllers\BenefitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// الصفحة الرئيسية تحول لتسجيل الدخول
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard يحول لقائمة الأيتام
Route::get('/dashboard', function () {
    return redirect()->route('orphans.index');
})->middleware(['auth'])->name('dashboard');

// Routes محمية بتسجيل الدخول
Route::middleware(['auth'])->group(function () {
    
    // إدارة الملف الشخصي
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ========================================
    // Routes للعرض فقط (Viewer + Admin)
    // ========================================
    
    // عرض قائمة الأيتام
    Route::get('/orphans', [OrphanController::class, 'index'])->name('orphans.index');
    
    // عرض القالب الرسمي
    Route::get('/orphans/{orphan}/template', [OrphanController::class, 'template'])->name('orphans.template');
    
    // عرض استفادات يتيم
    Route::get('/orphans/{orphan}/benefits', [BenefitController::class, 'index'])->name('orphans.benefits.index');
    
    // ========================================
    // Routes للإدارة (Admin فقط)
    // ========================================
    Route::middleware(['role:admin'])->group(function () {
        
        // إضافة يتيم
        Route::get('/orphans/create', [OrphanController::class, 'create'])->name('orphans.create');
        Route::post('/orphans', [OrphanController::class, 'store'])->name('orphans.store');
        
        // تعديل يتيم
        Route::get('/orphans/{orphan}/edit', [OrphanController::class, 'edit'])->name('orphans.edit');
        Route::put('/orphans/{orphan}', [OrphanController::class, 'update'])->name('orphans.update');
        
        // حذف يتيم
        Route::delete('/orphans/{orphan}', [OrphanController::class, 'destroy'])->name('orphans.destroy');
        
        // إضافة استفادة
        Route::get('/orphans/{orphan}/benefits/create', [BenefitController::class, 'create'])->name('orphans.benefits.create');
        Route::post('/orphans/{orphan}/benefits', [BenefitController::class, 'store'])->name('orphans.benefits.store');
        
        // تعديل استفادة
        Route::get('/orphans/{orphan}/benefits/{benefit}/edit', [BenefitController::class, 'edit'])->name('orphans.benefits.edit');
        Route::put('/orphans/{orphan}/benefits/{benefit}', [BenefitController::class, 'update'])->name('orphans.benefits.update');
        
        // حذف استفادة
        Route::delete('/orphans/{orphan}/benefits/{benefit}', [BenefitController::class, 'destroy'])->name('orphans.benefits.destroy');
    });
});

require __DIR__.'/auth.php';
