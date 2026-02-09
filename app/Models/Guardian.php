<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Guardian extends Model
{
    use HasFactory;

    protected $fillable = [
        'orphan_id',
        'full_name',
        'relationship',
        'national_id',
        'phone',
        'address',
        'father_death_date',
        'death_cause',
        'social_economic_status',
    ];

    protected $casts = [
        'father_death_date' => 'date',
    ];

    /**
     * العلاقة مع اليتيم
     */
    public function orphan()
    {
        return $this->belongsTo(Orphan::class);
    }

    /**
     * تاريخ وفاة الأب بالتنسيق العربي
     */
    public function getFormattedDeathDateAttribute()
    {
        return $this->father_death_date ? $this->father_death_date->format('d / m / Y') . 'م' : '';
    }
}
