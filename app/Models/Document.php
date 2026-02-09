<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'orphan_id',
        'type',
        'file_path',
        'original_name',
    ];

    /**
     * أنواع الوثائق
     */
    const TYPE_BIRTH = 'birth_certificate';
    const TYPE_DEATH = 'death_certificate';
    const TYPE_CUSTODY = 'custody_certificate';
    const TYPE_MOTHER_ID = 'mother_id';

    /**
     * أسماء الوثائق بالعربي
     */
    public static $typeNames = [
        self::TYPE_BIRTH => 'شهادة ميلاد اليتيم',
        self::TYPE_DEATH => 'إفادة وفاة الأب',
        self::TYPE_CUSTODY => 'شهادة الوصاية القانونية',
        self::TYPE_MOTHER_ID => 'صورة هوية الأم',
    ];

    /**
     * العلاقة مع اليتيم
     */
    public function orphan()
    {
        return $this->belongsTo(Orphan::class);
    }

    /**
     * اسم نوع الوثيقة بالعربي
     */
    public function getTypeNameAttribute()
    {
        return self::$typeNames[$this->type] ?? $this->type;
    }
}
