@extends('layouts.app')

@section('title', 'إضافة استفادة - ' . $orphan->full_name)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">إضافة استفادة جديدة</h1>
        <p style="color: var(--text-gray); margin-top: 5px;">
            <strong>{{ $orphan->full_name }}</strong> - رقم الملف: {{ $orphan->file_number }}
        </p>
    </div>
    <a href="{{ route('orphans.benefits.index', $orphan) }}" class="btn btn-secondary">
        <svg viewBox="0 0 24 24" width="18" height="18">
            <path fill="currentColor" d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
        العودة للسجل
    </a>
</div>

<div class="content-card">
    <form action="{{ route('orphans.benefits.store', $orphan) }}" method="POST">
        @csrf
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label required">نوع الاستفادة</label>
                <select name="benefit_type" class="form-control @error('benefit_type') error @enderror" required>
                    <option value="">-- اختر نوع الاستفادة --</option>
                    @foreach($types as $key => $label)
                        <option value="{{ $key }}" {{ old('benefit_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('benefit_type')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label required">تاريخ الاستفادة</label>
                <input type="date" name="benefit_date" value="{{ old('benefit_date', date('Y-m-d')) }}" 
                       class="form-control @error('benefit_date') error @enderror" required>
                @error('benefit_date')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">المبلغ (إن وجد)</label>
                <input type="number" name="amount" value="{{ old('amount') }}" 
                       class="form-control @error('amount') error @enderror" 
                       placeholder="0" step="0.01" min="0">
                @error('amount')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">الوصف</label>
                <input type="text" name="description" value="{{ old('description') }}" 
                       class="form-control @error('description') error @enderror"
                       placeholder="وصف مختصر للاستفادة">
                @error('description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">ملاحظات إضافية</label>
            <textarea name="notes" class="form-control" rows="3" 
                      placeholder="أي ملاحظات إضافية...">{{ old('notes') }}</textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" width="18" height="18">
                    <path fill="currentColor" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
                حفظ الاستفادة
            </button>
            <a href="{{ route('orphans.benefits.index', $orphan) }}" class="btn btn-secondary">إلغاء</a>
        </div>
    </form>
</div>
@endsection
