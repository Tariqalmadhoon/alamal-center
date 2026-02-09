@extends('layouts.app')

@section('title', 'إضافة يتيم جديد')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            إضافة يتيم جديد
        </h2>
        <a href="{{ route('orphans.index') }}" class="btn btn-secondary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            العودة للقائمة
        </a>
    </div>
    
    <div class="card-body">
        <form action="{{ route('orphans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- بيانات اليتيم -->
            <div class="section-divider">
                <div class="section-divider-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <h3 class="section-divider-title">البيانات الأساسية لليتيم</h3>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">الاسم الرباعي</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" 
                           class="form-control @error('full_name') error @enderror" 
                           placeholder="مثال: أحمد محمد علي حسن" required>
                    @error('full_name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label required">رقم الهوية</label>
                    <input type="text" name="national_id" value="{{ old('national_id') }}" 
                           class="form-control @error('national_id') error @enderror" 
                           placeholder="أدخل رقم الهوية" required>
                    @error('national_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">تاريخ الميلاد</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}" 
                           class="form-control @error('birth_date') error @enderror" required>
                    @error('birth_date')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label required">الجنس</label>
                    <select name="gender" class="form-control @error('gender') error @enderror" required>
                        <option value="">اختر الجنس</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                    </select>
                    @error('gender')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label required">الحالة الاجتماعية</label>
                    <select name="social_status" class="form-control @error('social_status') error @enderror" required>
                        <option value="">اختر الحالة</option>
                        <option value="يتيم الأب" {{ old('social_status') == 'يتيم الأب' ? 'selected' : '' }}>يتيم الأب</option>
                        <option value="يتيمة الأب" {{ old('social_status') == 'يتيمة الأب' ? 'selected' : '' }}>يتيمة الأب</option>
                        <option value="يتيم الأم" {{ old('social_status') == 'يتيم الأم' ? 'selected' : '' }}>يتيم الأم</option>
                        <option value="يتيمة الأم" {{ old('social_status') == 'يتيمة الأم' ? 'selected' : '' }}>يتيمة الأم</option>
                        <option value="يتيم الأبوين" {{ old('social_status') == 'يتيم الأبوين' ? 'selected' : '' }}>يتيم الأبوين</option>
                    </select>
                    @error('social_status')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">ملاحظات عامة</label>
                <textarea name="notes" class="form-control" rows="3" 
                          placeholder="أي ملاحظات إضافية عن الطفل...">{{ old('notes') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">الصورة الشخصية</label>
                <div class="photo-upload-container">
                    <label class="file-upload photo-upload-box">
                        <input type="file" name="photo" accept="image/*" onchange="previewImage(this, 'photo-preview')">
                        <svg class="file-upload-icon" viewBox="0 0 24 24">
                            <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                        </svg>
                        <div class="file-upload-text">اضغط لرفع صورة الطفل (اختياري)</div>
                        <div class="file-preview" id="photo-preview"></div>
                    </label>
                </div>
            </div>

            <!-- بيانات الوصي -->
            <div class="section-divider">
                <div class="section-divider-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                    </svg>
                </div>
                <h3 class="section-divider-title">بيانات الأم / الوصي القانوني</h3>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">اسم الوصي الكامل</label>
                    <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" 
                           class="form-control @error('guardian_name') error @enderror" 
                           placeholder="مثال: فاطمة أحمد محمد" required>
                    @error('guardian_name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label required">صلة القرابة</label>
                    <select name="guardian_relationship" class="form-control @error('guardian_relationship') error @enderror" required>
                        <option value="">اختر صلة القرابة</option>
                        <option value="الأم (الوصية القانونية)" {{ old('guardian_relationship') == 'الأم (الوصية القانونية)' ? 'selected' : '' }}>الأم (الوصية القانونية)</option>
                        <option value="الجد" {{ old('guardian_relationship') == 'الجد' ? 'selected' : '' }}>الجد</option>
                        <option value="الجدة" {{ old('guardian_relationship') == 'الجدة' ? 'selected' : '' }}>الجدة</option>
                        <option value="العم" {{ old('guardian_relationship') == 'العم' ? 'selected' : '' }}>العم</option>
                        <option value="العمة" {{ old('guardian_relationship') == 'العمة' ? 'selected' : '' }}>العمة</option>
                        <option value="الخال" {{ old('guardian_relationship') == 'الخال' ? 'selected' : '' }}>الخال</option>
                        <option value="الخالة" {{ old('guardian_relationship') == 'الخالة' ? 'selected' : '' }}>الخالة</option>
                        <option value="أخرى" {{ old('guardian_relationship') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                    </select>
                    @error('guardian_relationship')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">رقم هوية الوصي</label>
                    <input type="text" name="guardian_national_id" value="{{ old('guardian_national_id') }}" 
                           class="form-control" placeholder="أدخل رقم هوية الوصي">
                </div>
                
                <div class="form-group">
                    <label class="form-label">رقم التواصل</label>
                    <input type="text" name="guardian_phone" value="{{ old('guardian_phone') }}" 
                           class="form-control" placeholder="مثال: 0599123456">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">مكان السكن</label>
                <input type="text" name="guardian_address" value="{{ old('guardian_address') }}" 
                       class="form-control" placeholder="مثال: القرارة – خانيونس – قطاع غزة">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">تاريخ وفاة الأب</label>
                    <input type="date" name="father_death_date" value="{{ old('father_death_date') }}" 
                           class="form-control">
                </div>
                
                <div class="form-group">
                    <label class="form-label">سبب الوفاة</label>
                    <select name="death_cause" class="form-control">
                        <option value="">اختر سبب الوفاة</option>
                        <option value="شهيد - العدوان على غزة" {{ old('death_cause') == 'شهيد - العدوان على غزة' ? 'selected' : '' }}>شهيد - العدوان على غزة</option>
                        <option value="مرض" {{ old('death_cause') == 'مرض' ? 'selected' : '' }}>مرض</option>
                        <option value="حادث" {{ old('death_cause') == 'حادث' ? 'selected' : '' }}>حادث</option>
                        <option value="أسباب طبيعية" {{ old('death_cause') == 'أسباب طبيعية' ? 'selected' : '' }}>أسباب طبيعية</option>
                        <option value="أخرى" {{ old('death_cause') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">الوضع الاجتماعي والاقتصادي</label>
                <textarea name="social_economic_status" class="form-control" rows="3" 
                          placeholder="وصف الحالة الاجتماعية والاقتصادية للأسرة...">{{ old('social_economic_status') }}</textarea>
            </div>

            <!-- الوثائق -->
            <div class="section-divider">
                <div class="section-divider-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                    </svg>
                </div>
                <h3 class="section-divider-title">الوثائق الرسمية المرفقة</h3>
            </div>

            <div class="documents-grid">
                <div class="form-group">
                    <label class="form-label">شهادة ميلاد اليتيم</label>
                    <label class="file-upload">
                        <input type="file" name="birth_certificate" accept="image/*" onchange="previewImage(this, 'birth-preview')">
                        <svg class="file-upload-icon" viewBox="0 0 24 24">
                            <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6z"/>
                        </svg>
                        <div class="file-upload-text">رفع شهادة الميلاد</div>
                        <div class="file-preview" id="birth-preview"></div>
                    </label>
                </div>
                
                <div class="form-group">
                    <label class="form-label">إفادة وفاة الأب</label>
                    <label class="file-upload">
                        <input type="file" name="death_certificate" accept="image/*" onchange="previewImage(this, 'death-preview')">
                        <svg class="file-upload-icon" viewBox="0 0 24 24">
                            <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6z"/>
                        </svg>
                        <div class="file-upload-text">رفع إفادة الوفاة</div>
                        <div class="file-preview" id="death-preview"></div>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label">شهادة الوصاية القانونية</label>
                    <label class="file-upload">
                        <input type="file" name="custody_certificate" accept="image/*" onchange="previewImage(this, 'custody-preview')">
                        <svg class="file-upload-icon" viewBox="0 0 24 24">
                            <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6z"/>
                        </svg>
                        <div class="file-upload-text">رفع شهادة الوصاية</div>
                        <div class="file-preview" id="custody-preview"></div>
                    </label>
                </div>
                
                <div class="form-group">
                    <label class="form-label">صورة هوية الأم</label>
                    <label class="file-upload">
                        <input type="file" name="mother_id" accept="image/*" onchange="previewImage(this, 'mother-id-preview')">
                        <svg class="file-upload-icon" viewBox="0 0 24 24">
                            <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6z"/>
                        </svg>
                        <div class="file-upload-text">رفع صورة هوية الأم</div>
                        <div class="file-preview" id="mother-id-preview"></div>
                    </label>
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 15px; justify-content: flex-start;">
                <button type="submit" class="btn btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                    </svg>
                    حفظ بيانات اليتيم
                </button>
                <a href="{{ route('orphans.index') }}" class="btn btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" alt="معاينة">';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
