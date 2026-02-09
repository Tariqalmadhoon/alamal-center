<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\Orphan;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    /**
     * عرض قائمة استفادات يتيم محدد
     */
    public function index(Orphan $orphan)
    {
        $benefits = $orphan->benefits()->with('creator')->latest('benefit_date')->paginate(15);
        
        return view('benefits.index', compact('orphan', 'benefits'));
    }

    /**
     * عرض نموذج إضافة استفادة
     */
    public function create(Orphan $orphan)
    {
        $types = Benefit::TYPES;
        
        return view('benefits.create', compact('orphan', 'types'));
    }

    /**
     * حفظ استفادة جديدة
     */
    public function store(Request $request, Orphan $orphan)
    {
        $validated = $request->validate([
            'benefit_type' => 'required|string',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'benefit_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ], [
            'benefit_type.required' => 'نوع الاستفادة مطلوب',
            'benefit_date.required' => 'تاريخ الاستفادة مطلوب',
            'amount.numeric' => 'المبلغ يجب أن يكون رقماً',
        ]);

        $validated['orphan_id'] = $orphan->id;
        $validated['created_by'] = auth()->id();

        Benefit::create($validated);

        return redirect()->route('orphans.benefits.index', $orphan)
            ->with('success', 'تم إضافة الاستفادة بنجاح');
    }

    /**
     * عرض نموذج تعديل استفادة
     */
    public function edit(Orphan $orphan, Benefit $benefit)
    {
        $types = Benefit::TYPES;
        
        return view('benefits.edit', compact('orphan', 'benefit', 'types'));
    }

    /**
     * تحديث استفادة
     */
    public function update(Request $request, Orphan $orphan, Benefit $benefit)
    {
        $validated = $request->validate([
            'benefit_type' => 'required|string',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'benefit_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ], [
            'benefit_type.required' => 'نوع الاستفادة مطلوب',
            'benefit_date.required' => 'تاريخ الاستفادة مطلوب',
            'amount.numeric' => 'المبلغ يجب أن يكون رقماً',
        ]);

        $benefit->update($validated);

        return redirect()->route('orphans.benefits.index', $orphan)
            ->with('success', 'تم تحديث الاستفادة بنجاح');
    }

    /**
     * حذف استفادة
     */
    public function destroy(Orphan $orphan, Benefit $benefit)
    {
        $benefit->delete();

        return redirect()->route('orphans.benefits.index', $orphan)
            ->with('success', 'تم حذف الاستفادة بنجاح');
    }
}
