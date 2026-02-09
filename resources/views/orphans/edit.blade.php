@extends('layouts.app')

@section('title', 'تعديل بيانات: ' . $orphan->full_name)

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
            </svg>
            تعديل بيانات: {{ $orphan->full_name }}
        </h2>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('orphans.template', $orphan) }}" class="btn btn-primary btn-sm">
                عرض القالب
            </a>
            <a href="{{ route('orphans.index') }}" class="btn btn-secondary">
                العودة للقائمة
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <form action="{{ route('orphans.update', $orphan) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- بيانات اليتيم -->
            <div class="section-divider">
                <div class="section-divider-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <h3 class="section-divider-title">البيانات الأساسية لليتيم</h3>
                <span style="margin-right: auto; background: var(--primary-green); color: white; padding: 5px 15px; border-radius: 20px; font-size: 13px;">
                    رقم الملف: {{ $orphan->file_number }}
                </span>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">الاسم الرباعي</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $orphan->full_name) }}" 
                           class="form-control @error('full_name') error @enderror" required>
                    @error('full_name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label required">رقم الهوية</label>
                    <input type="text" name="national_id" value="{{ old('national_id', $orphan->national_id) }}" 
                           class="form-control @error('national_id') error @enderror" required>
                    @error('national_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">تاريخ الميلاد</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $orphan->birth_date->format('Y-m-d')) }}" 
                           class="form-control @error('birth_date') error @enderror" required>
                    @error('birth_date')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label required">الجنس</label>
                    <select name="gender" class="form-control @error('gender') error @enderror" required>
                        <option value="male" {{ old('gender', $orphan->gender) == 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ old('gender', $orphan->gender) == 'female' ? 'selected' : '' }}>أنثى</option>
                    </select>
                    @error('gender')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label required">الحالة الاجتماعية</label>
                    <select name="social_status" class="form-control @error('social_status') error @enderror" required>
                        <option value="يتيم الأب" {{ old('social_status', $orphan->social_status) == 'يتيم الأب' ? 'selected' : '' }}>يتيم الأب</option>
                        <option value="يتيمة الأب" {{ old('social_status', $orphan->social_status) == 'يتيمة الأب' ? 'selected' : '' }}>يتيمة الأب</option>
                        <option value="يتيم الأم" {{ old('social_status', $orphan->social_status) == 'يتيم الأم' ? 'selected' : '' }}>يتيم الأم</option>
                        <option value="يتيمة الأم" {{ old('social_status', $orphan->social_status) == 'يتيمة الأم' ? 'selected' : '' }}>يتيمة الأم</option>
                        <option value="يتيم الأبوين" {{ old('social_status', $orphan->social_status) == 'يتيم الأبوين' ? 'selected' : '' }}>يتيم الأبوين</option>
                    </select>
                    @error('social_status')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">ملاحظات عامة</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes', $orphan->notes) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">الصورة الشخصية</label>
                <div class="photo-upload-container">
                    @if($orphan->photo)
                        <div class="current-photo">
                            <img src="{{ asset('storage/' . $orphan->photo) }}" alt="الصورة الحالية">
                            <p>الصورة الحالية</p>
                        </div>
                    @endif
                    <label class="file-upload photo-upload-box">
                        <input type="file" name="photo" accept="image/*" onchange="previewImage(this, 'photo-preview')">
                        <svg class="file-upload-icon" viewBox="0 0 24 24">
                            <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                        </svg>
                        <div class="file-upload-text">{{ $orphan->photo ? 'تغيير الصورة' : 'رفع صورة الطفل' }}</div>
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
                    <input type="text" name="guardian_name" value="{{ old('guardian_name', $orphan->guardian->full_name ?? '') }}" 
                           class="form-control @error('guardian_name') error @enderror" required>
                    @error('guardian_name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label required">صلة القرابة</label>
                    <select name="guardian_relationship" class="form-control @error('guardian_relationship') error @enderror" required>
                        @php $rel = old('guardian_relationship', $orphan->guardian->relationship ?? ''); @endphp
                        <option value="الأم (الوصية القانونية)" {{ $rel == 'الأم (الوصية القانونية)' ? 'selected' : '' }}>الأم (الوصية القانونية)</option>
                        <option value="الجد" {{ $rel == 'الجد' ? 'selected' : '' }}>الجد</option>
                        <option value="الجدة" {{ $rel == 'الجدة' ? 'selected' : '' }}>الجدة</option>
                        <option value="العم" {{ $rel == 'العم' ? 'selected' : '' }}>العم</option>
                        <option value="العمة" {{ $rel == 'العمة' ? 'selected' : '' }}>العمة</option>
                        <option value="الخال" {{ $rel == 'الخال' ? 'selected' : '' }}>الخال</option>
                        <option value="الخالة" {{ $rel == 'الخالة' ? 'selected' : '' }}>الخالة</option>
                        <option value="أخرى" {{ $rel == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                    </select>
                    @error('guardian_relationship')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">رقم هوية الوصي</label>
                    <input type="text" name="guardian_national_id" value="{{ old('guardian_national_id', $orphan->guardian->national_id ?? '') }}" 
                           class="form-control">
                </div>
                
                <div class="form-group">
                    <label class="form-label">رقم التواصل</label>
                    <input type="text" name="guardian_phone" value="{{ old('guardian_phone', $orphan->guardian->phone ?? '') }}" 
                           class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">مكان السكن</label>
                <input type="text" name="guardian_address" value="{{ old('guardian_address', $orphan->guardian->address ?? '') }}" 
                       class="form-control">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">تاريخ وفاة الأب</label>
                    <input type="date" name="father_death_date" value="{{ old('father_death_date', optional($orphan->guardian)->father_death_date?->format('Y-m-d')) }}" 
                           class="form-control">
                </div>
                
                <div class="form-group">
                    <label class="form-label">سبب الوفاة</label>
                    @php $cause = old('death_cause', $orphan->guardian->death_cause ?? ''); @endphp
                    <select name="death_cause" class="form-control">
                        <option value="">اختر سبب الوفاة</option>
                        <option value="شهيد - العدوان على غزة" {{ $cause == 'شهيد - العدوان على غزة' ? 'selected' : '' }}>شهيد - العدوان على غزة</option>
                        <option value="مرض" {{ $cause == 'مرض' ? 'selected' : '' }}>مرض</option>
                        <option value="حادث" {{ $cause == 'حادث' ? 'selected' : '' }}>حادث</option>
                        <option value="أسباب طبيعية" {{ $cause == 'أسباب طبيعية' ? 'selected' : '' }}>أسباب طبيعية</option>
                        <option value="أخرى" {{ $cause == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">الوضع الاجتماعي والاقتصادي</label>
                <textarea name="social_economic_status" class="form-control" rows="3">{{ old('social_economic_status', $orphan->guardian->social_economic_status ?? '') }}</textarea>
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
                @php $birthDoc = $orphan->getDocument('birth_certificate'); @endphp
                <div class="form-group">
                    <label class="form-label">شهادة ميلاد اليتيم</label>
                    @if($birthDoc)
                        <div class="doc-current-image">
                            <img src="{{ asset('storage/' . $birthDoc->file_path) }}" alt="شهادة الميلاد">
                            <p>الوثيقة الحالية</p>
                        </div>
                    @endif
                    <label class="file-upload">
                        <input type="file" name="birth_certificate" accept="image/*" onchange="previewImage(this, 'birth-preview')">
                        <svg class="file-upload-icon" viewBox="0 0 24 24">
                            <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6z"/>
                        </svg>
                        <div class="file-upload-text">{{ $birthDoc ? 'تغيير الوثيقة' : 'رفع شهادة الميلاد' }}</div>
                        <div class="file-preview" id="birth-preview"></div>
                    </label>
                </div>
                
                @php $deathDoc = $orphan->getDocument('death_certificate'); @endphp
                <div class="form-group">
                    <label class="form-label">إفادة وفاة الأب</label>
                    @if($deathDoc)
                        <div class="doc-current-image">
                            <img src="{{ asset('storage/' . $deathDoc->file_path) }}" alt="إفادة الوفاة">
                            <p>الوثيقة الحالية</p>
                        </div>
                    @endif
                    <label class="file-upload">
                        <input type="file" name="death_certificate" accept="image/*" onchange="previewImage(this, 'death-preview')">
                        <svg class="file-upload-icon" viewBox="0 0 24 24">
                            <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6z"/>
                        </svg>
                        <div class="file-upload-text">{{ $deathDoc ? 'تغيير الوثيقة' : 'رفع إفادة الوفاة' }}</div>
                        <div class="file-preview" id="death-preview"></div>
                    </label>
                </div>
                
                @php $custodyDoc = $orphan->getDocument('custody_certificate'); @endphp
                <div class="form-group">
                    <label class="form-label">شهادة الوصاية القانونية</label>
                    @if($custodyDoc)
                        <div class="doc-current-image">
                            <img src="{{ asset('storage/' . $custodyDoc->file_path) }}" alt="شهادة الوصاية">
                            <p>الوثيقة الحالية</p>
                        </div>
                    @endif
                    <label class="file-upload">
                        <input type="file" name="custody_certificate" accept="image/*" onchange="previewImage(this, 'custody-preview')">
                        <svg class="file-upload-icon" viewBox="0 0 24 24">
                            <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6z"/>
                        </svg>
                        <div class="file-upload-text">{{ $custodyDoc ? 'تغيير الوثيقة' : 'رفع شهادة الوصاية' }}</div>
                        <div class="file-preview" id="custody-preview"></div>
                    </label>
                </div>

                @php $motherIdDoc = $orphan->getDocument('mother_id'); @endphp
                <div class="form-group">
                    <label class="form-label">صورة هوية الأم</label>
                    @if($motherIdDoc)
                        <div class="doc-current-image">
                            <img src="{{ asset('storage/' . $motherIdDoc->file_path) }}" alt="هوية الأم">
                            <p>الوثيقة الحالية</p>
                        </div>
                    @endif
                    <label class="file-upload">
                        <input type="file" name="mother_id" accept="image/*" onchange="previewImage(this, 'mother-id-preview')">
                        <svg class="file-upload-icon" viewBox="0 0 24 24">
                            <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6z"/>
                        </svg>
                        <div class="file-upload-text">{{ $motherIdDoc ? 'تغيير الوثيقة' : 'رفع صورة هوية الأم' }}</div>
                        <div class="file-preview" id="mother-id-preview"></div>
                    </label>
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 15px; justify-content: flex-start;">
                <button type="submit" class="btn btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                    </svg>
                    حفظ التعديلات
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
