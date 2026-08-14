<?php

namespace App\Http\Controllers;

use App\Models\DeductionSetting;
use Illuminate\Http\Request;

class DeductionSettingController extends Controller
{
    public function index()
    {
        $settings = DeductionSetting::all();
        return view('deductions.index', compact('settings'));
    }

    public function create()
    {
        return view('deductions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fixed,percentage,tiered',
            'employee_share' => 'nullable|numeric',
            'employer_share' => 'nullable|numeric',
            'fixed_amount' => 'nullable|numeric',
            'minimum_salary' => 'nullable|numeric',
            'maximum_salary' => 'nullable|numeric',
            'tier_data' => 'nullable',
            'is_active' => 'boolean',
        ]);

        if (isset($validated['tier_data']) && is_string($validated['tier_data'])) {
            $validated['tier_data'] = json_decode($validated['tier_data'], true);
        }

        DeductionSetting::create($validated);

        return redirect()->route('deductions.index')
            ->with('success', 'Deduction setting created successfully');
    }

    public function edit(DeductionSetting $deduction)
    {
        return view('deductions.edit', compact('deduction'));
    }

    public function update(Request $request, DeductionSetting $deduction)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fixed,percentage,tiered',
            'employee_share' => 'nullable|numeric',
            'employer_share' => 'nullable|numeric',
            'fixed_amount' => 'nullable|numeric',
            'minimum_salary' => 'nullable|numeric',
            'maximum_salary' => 'nullable|numeric',
            'tier_data' => 'nullable',
            'is_active' => 'boolean',
        ]);

        if (isset($validated['tier_data']) && is_string($validated['tier_data'])) {
            $validated['tier_data'] = json_decode($validated['tier_data'], true);
        }

        $deduction->update($validated);

        return redirect()->route('deductions.index')
            ->with('success', 'Deduction setting updated successfully');
    }

    public function destroy(DeductionSetting $deduction)
    {
        $deduction->delete();

        return redirect()->route('deductions.index')
            ->with('success', 'Deduction setting deleted');
    }
}
