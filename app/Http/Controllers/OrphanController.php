<?php

namespace App\Http\Controllers;

use App\Models\Orphan;
use App\Models\Guardian;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrphanController extends Controller
{
    /**
     * عرض قائمة الأيتام
     */
    public function index(Request $request)
    {
        $query = Orphan::with(['guardian', 'documents']);
        
        // البحث
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('file_number', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%");
            });
        }
        
        $orphans = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('orphans.index', compact('orphans'));
    }

    /**
     * عرض نموذج إضافة يتيم جديد
     */
    public function create()
    {
        return view('orphans.create');
    }

    /**
     * حفظ يتيم جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'national_id' => 'required|string|max:20|unique:orphans,national_id',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'social_status' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:5120',
            
            // بيانات الوصي
            'guardian_name' => 'required|string|max:255',
            'guardian_relationship' => 'required|string|max:255',
            'guardian_national_id' => 'nullable|string|max:20',
            'guardian_phone' => 'nullable|string|max:20',
            'guardian_address' => 'nullable|string|max:500',
            'father_death_date' => 'nullable|date',
            'death_cause' => 'nullable|string|max:255',
            'social_economic_status' => 'nullable|string',
            
            // الوثائق
            'birth_certificate' => 'nullable|image|max:5120',
            'death_certificate' => 'nullable|image|max:5120',
            'custody_certificate' => 'nullable|image|max:5120',
            'mother_id' => 'nullable|image|max:5120',
        ]);

        // إنشاء اليتيم
        $orphan = Orphan::create([
            'file_number' => Orphan::generateFileNumber(),
            'full_name' => $validated['full_name'],
            'national_id' => $validated['national_id'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'social_status' => $validated['social_status'],
            'notes' => $validated['notes'] ?? null,
            'registration_date' => now(),
            'approval_date' => now(),
        ]);

        // رفع الصورة الشخصية
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $orphan->update(['photo' => $path]);
        }

        // إنشاء الوصي
        Guardian::create([
            'orphan_id' => $orphan->id,
            'full_name' => $validated['guardian_name'],
            'relationship' => $validated['guardian_relationship'],
            'national_id' => $validated['guardian_national_id'] ?? null,
            'phone' => $validated['guardian_phone'] ?? null,
            'address' => $validated['guardian_address'] ?? null,
            'father_death_date' => $validated['father_death_date'] ?? null,
            'death_cause' => $validated['death_cause'] ?? null,
            'social_economic_status' => $validated['social_economic_status'] ?? null,
        ]);

        // رفع الوثائق
        $documentTypes = [
            'birth_certificate' => Document::TYPE_BIRTH,
            'death_certificate' => Document::TYPE_DEATH,
            'custody_certificate' => Document::TYPE_CUSTODY,
            'mother_id' => Document::TYPE_MOTHER_ID,
        ];

        foreach ($documentTypes as $inputName => $docType) {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $path = $file->store('documents', 'public');
                
                Document::create([
                    'orphan_id' => $orphan->id,
                    'type' => $docType,
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('orphans.index')
            ->with('success', 'تم إضافة اليتيم بنجاح! رقم الملف: ' . $orphan->file_number);
    }

    /**
     * عرض تفاصيل اليتيم
     */
    public function show(Orphan $orphan)
    {
        $orphan->load(['guardian', 'documents']);
        return view('orphans.show', compact('orphan'));
    }

    /**
     * عرض نموذج تعديل اليتيم
     */
    public function edit(Orphan $orphan)
    {
        $orphan->load(['guardian', 'documents']);
        return view('orphans.edit', compact('orphan'));
    }

    /**
     * تحديث بيانات اليتيم
     */
    public function update(Request $request, Orphan $orphan)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'national_id' => 'required|string|max:20|unique:orphans,national_id,' . $orphan->id,
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'social_status' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:5120',
            
            'guardian_name' => 'required|string|max:255',
            'guardian_relationship' => 'required|string|max:255',
            'guardian_national_id' => 'nullable|string|max:20',
            'guardian_phone' => 'nullable|string|max:20',
            'guardian_address' => 'nullable|string|max:500',
            'father_death_date' => 'nullable|date',
            'death_cause' => 'nullable|string|max:255',
            'social_economic_status' => 'nullable|string',
            
            'birth_certificate' => 'nullable|image|max:5120',
            'death_certificate' => 'nullable|image|max:5120',
            'custody_certificate' => 'nullable|image|max:5120',
            'mother_id' => 'nullable|image|max:5120',
        ]);

        // تحديث بيانات اليتيم
        $orphan->update([
            'full_name' => $validated['full_name'],
            'national_id' => $validated['national_id'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'social_status' => $validated['social_status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // تحديث الصورة
        if ($request->hasFile('photo')) {
            // حذف الصورة القديمة
            if ($orphan->photo) {
                Storage::disk('public')->delete($orphan->photo);
            }
            $path = $request->file('photo')->store('photos', 'public');
            $orphan->update(['photo' => $path]);
        }

        // تحديث الوصي
        $orphan->guardian()->updateOrCreate(
            ['orphan_id' => $orphan->id],
            [
                'full_name' => $validated['guardian_name'],
                'relationship' => $validated['guardian_relationship'],
                'national_id' => $validated['guardian_national_id'] ?? null,
                'phone' => $validated['guardian_phone'] ?? null,
                'address' => $validated['guardian_address'] ?? null,
                'father_death_date' => $validated['father_death_date'] ?? null,
                'death_cause' => $validated['death_cause'] ?? null,
                'social_economic_status' => $validated['social_economic_status'] ?? null,
            ]
        );

        // تحديث الوثائق
        $documentTypes = [
            'birth_certificate' => Document::TYPE_BIRTH,
            'death_certificate' => Document::TYPE_DEATH,
            'custody_certificate' => Document::TYPE_CUSTODY,
            'mother_id' => Document::TYPE_MOTHER_ID,
        ];

        foreach ($documentTypes as $inputName => $docType) {
            if ($request->hasFile($inputName)) {
                // حذف الوثيقة القديمة
                $oldDoc = $orphan->documents()->where('type', $docType)->first();
                if ($oldDoc) {
                    Storage::disk('public')->delete($oldDoc->file_path);
                    $oldDoc->delete();
                }
                
                $file = $request->file($inputName);
                $path = $file->store('documents', 'public');
                
                Document::create([
                    'orphan_id' => $orphan->id,
                    'type' => $docType,
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('orphans.index')
            ->with('success', 'تم تحديث بيانات اليتيم بنجاح!');
    }

    /**
     * حذف اليتيم
     */
    public function destroy(Orphan $orphan)
    {
        // حذف الصور والوثائق من التخزين
        if ($orphan->photo) {
            Storage::disk('public')->delete($orphan->photo);
        }
        
        foreach ($orphan->documents as $doc) {
            Storage::disk('public')->delete($doc->file_path);
        }
        
        $orphan->delete();
        
        return redirect()->route('orphans.index')
            ->with('success', 'تم حذف ملف اليتيم بنجاح!');
    }

    /**
     * عرض القالب الرسمي لليتيم
     */
    public function template(Orphan $orphan)
    {
        $orphan->load(['guardian', 'documents']);
        return view('orphans.template', compact('orphan'));
    }
}
