<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;

    protected $fillable = [
        'orphan_id',
        'benefit_type',
        'description',
        'amount',
        'benefit_date',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'benefit_date' => 'date',
        'amount' => 'decimal:2',
    ];

    // أنواع الاستفادات
    const TYPES = [
        'financial' => 'مساعدة مالية',
        'food' => 'سلة غذائية',
        'clothing' => 'ملابس',
        'school' => 'مستلزمات مدرسية',
        'medical' => 'علاج طبي',
        'sponsorship' => 'كفالة شهرية',
        'eid' => 'كسوة العيد',
        'other' => 'أخرى',
    ];

    // العلاقة مع اليتيم
    public function orphan()
    {
        return $this->belongsTo(Orphan::class);
    }

    // العلاقة مع المستخدم الذي أضاف الاستفادة
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // الحصول على اسم نوع الاستفادة
    public function getTypeNameAttribute()
    {
        return self::TYPES[$this->benefit_type] ?? $this->benefit_type;
    }

    // تنسيق التاريخ بالعربية
    public function getFormattedDateAttribute()
    {
        return $this->benefit_date ? $this->benefit_date->format('Y/m/d') : '';
    }
}
