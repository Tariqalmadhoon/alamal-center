<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrphanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// الصفحة الرئيسية - توجيه لقائمة الأيتام
Route::get('/', function () {
    return redirect()->route('orphans.index');
});

// مسارات إدارة الأيتام
Route::resource('orphans', OrphanController::class);

// عرض القالب الرسمي
Route::get('orphans/{orphan}/template', [OrphanController::class, 'template'])->name('orphans.template');
