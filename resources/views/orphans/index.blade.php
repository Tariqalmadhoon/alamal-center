@extends('layouts.app')

@section('title', 'قائمة الأيتام')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
            </svg>
            قائمة الأيتام المسجلين
        </h2>
        <a href="{{ route('orphans.create') }}" class="btn btn-primary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            إضافة يتيم جديد
        </a>
    </div>
    
    <div class="card-body">
        <!-- Search -->
        <form action="{{ route('orphans.index') }}" method="GET" class="search-box">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="البحث بالاسم أو رقم الملف أو رقم الهوية..." 
                   class="form-control search-input">
            <button type="submit" class="btn btn-primary btn-sm">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
                بحث
            </button>
            @if(request('search'))
                <a href="{{ route('orphans.index') }}" class="btn btn-secondary btn-sm">إلغاء البحث</a>
            @endif
        </form>

        @if($orphans->count() > 0)
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>الصورة</th>
                            <th>رقم الملف</th>
                            <th>الاسم الرباعي</th>
                            <th>رقم الهوية</th>
                            <th>العمر</th>
                            <th>الجنس</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orphans as $orphan)
                            <tr>
                                <td>
                                    @if($orphan->photo)
                                        <img src="{{ asset('storage/' . $orphan->photo) }}" alt="صورة اليتيم" class="table-photo">
                                    @else
                                        <div class="table-photo" style="background: #e2e8f0; display: flex; align-items: center; justify-content: center;">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="#94a3b8">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $orphan->file_number }}</strong></td>
                                <td>{{ $orphan->full_name }}</td>
                                <td>{{ $orphan->national_id }}</td>
                                <td>{{ $orphan->age_text }}</td>
                                <td>
                                    <span class="badge badge-{{ $orphan->gender }}">
                                        {{ $orphan->gender_text }}
                                    </span>
                                </td>
                                <td>{{ $orphan->social_status }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('orphans.template', $orphan) }}" class="btn btn-primary btn-sm" title="عرض القالب الرسمي">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>
                                            </svg>
                                            القالب
                                        </a>
                                        <a href="{{ route('orphans.edit', $orphan) }}" class="btn btn-secondary btn-sm" title="تعديل">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('orphans.destroy', $orphan) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الملف؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="حذف">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                {{ $orphans->links() }}
            </div>
        @else
            <div class="empty-state">
                <svg viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                <h3>لا يوجد أيتام مسجلين حتى الآن</h3>
                <p>ابدأ بإضافة أول يتيم للنظام</p>
                <a href="{{ route('orphans.create') }}" class="btn btn-primary" style="margin-top: 15px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    إضافة يتيم جديد
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
