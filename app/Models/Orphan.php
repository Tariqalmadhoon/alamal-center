<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Orphan extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_number',
        'full_name',
        'national_id',
        'birth_date',
        'gender',
        'social_status',
        'photo',
        'notes',
        'registration_date',
        'approval_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'registration_date' => 'date',
        'approval_date' => 'date',
    ];

    /**
     * العلاقة مع الوصي
     */
    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

    /**
     * العلاقة مع الوثائق
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * حساب العمر تلقائياً
     */
    public function getAgeAttribute()
    {
        return $this->birth_date ? Carbon::parse($this->birth_date)->age : null;
    }

    /**
     * الحصول على العمر بالنص العربي
     */
    public function getAgeTextAttribute()
    {
        $age = $this->age;
        if (!$age) return '';
        
        if ($age == 1) return 'سنة واحدة';
        if ($age == 2) return 'سنتان';
        if ($age >= 3 && $age <= 10) return $age . ' سنوات';
        return $age . ' سنة';
    }

    /**
     * تاريخ الميلاد بالتنسيق العربي
     */
    public function getFormattedBirthDateAttribute()
    {
        return $this->birth_date ? $this->birth_date->format('d / m / Y') . 'م' : '';
    }

    /**
     * تاريخ التسجيل بالتنسيق العربي
     */
    public function getFormattedRegistrationDateAttribute()
    {
        return $this->registration_date ? $this->registration_date->format('d/m/Y') : '';
    }

    /**
     * تاريخ الاعتماد بالتنسيق العربي
     */
    public function getFormattedApprovalDateAttribute()
    {
        return $this->approval_date ? $this->approval_date->format('d / m / Y') . 'م' : date('d / m / Y') . 'م';
    }

    /**
     * الجنس بالعربي
     */
    public function getGenderTextAttribute()
    {
        return $this->gender === 'male' ? 'ذكر' : 'أنثى';
    }

    /**
     * توليد رقم ملف جديد
     */
    public static function generateFileNumber()
    {
        $year = date('Y');
        $lastOrphan = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        $nextNumber = $lastOrphan ? ((int)substr($lastOrphan->file_number, -4) + 1) : 1;
        
        return 'AMC-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * الحصول على وثيقة محددة
     */
    public function getDocument($type)
    {
        return $this->documents()->where('type', $type)->first();
    }

    /**
     * العلاقة مع الاستفادات
     */
    public function benefits()
    {
        return $this->hasMany(Benefit::class);
    }

    /**
     * آخر استفادة
     */
    public function getLastBenefitAttribute()
    {
        return $this->benefits()->latest('benefit_date')->first();
    }

    /**
     * عدد الاستفادات
     */
    public function getBenefitsCountAttribute()
    {
        return $this->benefits()->count();
    }
}
