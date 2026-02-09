@extends('layouts.app')

@section('title', 'سجل استفادات - ' . $orphan->full_name)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">سجل الاستفادات</h1>
        <p style="color: var(--text-gray); margin-top: 5px;">
            <strong>{{ $orphan->full_name }}</strong> - رقم الملف: {{ $orphan->file_number }}
        </p>
    </div>
    <div class="header-actions">
        <a href="{{ route('orphans.index') }}" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" width="18" height="18">
                <path fill="currentColor" d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            العودة للقائمة
        </a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('orphans.benefits.create', $orphan) }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" width="18" height="18">
                <path fill="currentColor" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            إضافة استفادة جديدة
        </a>
        @endif
    </div>
</div>

<!-- إحصائيات سريعة -->
<div class="stats-row" style="margin-bottom: 30px;">
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #059669, #10b981);">
            <svg viewBox="0 0 24 24" width="24" height="24">
                <path fill="white" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value">{{ $benefits->total() }}</span>
            <span class="stat-label">إجمالي الاستفادات</span>
        </div>
    </div>
    
    @php
        $totalAmount = $orphan->benefits()->sum('amount');
        $lastBenefit = $orphan->last_benefit;
    @endphp
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">
            <svg viewBox="0 0 24 24" width="24" height="24">
                <path fill="white" d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value">{{ number_format($totalAmount, 0) }}</span>
            <span class="stat-label">إجمالي المبالغ</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa);">
            <svg viewBox="0 0 24 24" width="24" height="24">
                <path fill="white" d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM9 10H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm-8 4H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2z"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value">{{ $lastBenefit ? $lastBenefit->benefit_date->format('Y/m/d') : '-' }}</span>
            <span class="stat-label">آخر استفادة</span>
        </div>
    </div>
</div>

<!-- جدول الاستفادات -->
<div class="content-card">
    @if($benefits->count() > 0)
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>نوع الاستفادة</th>
                    <th>الوصف</th>
                    <th>المبلغ</th>
                    <th>التاريخ</th>
                    <th>ملاحظات</th>
                    <th>بواسطة</th>
                    @if(auth()->user()->isAdmin())
                    <th>الإجراءات</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($benefits as $index => $benefit)
                <tr>
                    <td>{{ $benefits->firstItem() + $index }}</td>
                    <td>
                        <span class="badge badge-success">{{ $benefit->type_name }}</span>
                    </td>
                    <td>{{ $benefit->description ?? '-' }}</td>
                    <td>
                        @if($benefit->amount)
                            <strong style="color: var(--primary-green);">{{ number_format($benefit->amount, 0) }}</strong>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $benefit->benefit_date->format('Y/m/d') }}</td>
                    <td>{{ $benefit->notes ?? '-' }}</td>
                    <td>{{ $benefit->creator->name ?? 'غير محدد' }}</td>
                    @if(auth()->user()->isAdmin())
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('orphans.benefits.edit', [$orphan, $benefit]) }}" class="btn-icon" title="تعديل">
                                <svg viewBox="0 0 24 24" width="16" height="16">
                                    <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                </svg>
                            </a>
                            <form action="{{ route('orphans.benefits.destroy', [$orphan, $benefit]) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذه الاستفادة؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-danger" title="حذف">
                                    <svg viewBox="0 0 24 24" width="16" height="16">
                                        <path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 20px;">
        {{ $benefits->links() }}
    </div>
    @else
    <div class="empty-state">
        <svg viewBox="0 0 24 24" width="64" height="64" style="fill: #9ca3af; margin-bottom: 20px;">
            <path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-1 12H5c-.55 0-1-.45-1-1V9c0-.55.45-1 1-1h14c.55 0 1 .45 1 1v8c0 .55-.45 1-1 1z"/>
        </svg>
        <h3 style="color: #6b7280; margin-bottom: 10px;">لا توجد استفادات مسجلة</h3>
        <p style="color: #9ca3af;">لم يتم تسجيل أي استفادات لهذا اليتيم بعد</p>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('orphans.benefits.create', $orphan) }}" class="btn btn-primary" style="margin-top: 20px;">
            إضافة أول استفادة
        </a>
        @endif
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stat-info {
        display: flex;
        flex-direction: column;
    }
    
    .stat-value {
        font-size: 22px;
        font-weight: 700;
        color: #1f2937;
    }
    
    .stat-label {
        font-size: 13px;
        color: #6b7280;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .badge-success {
        background: #d1fae5;
        color: #047857;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
</style>
@endpush
