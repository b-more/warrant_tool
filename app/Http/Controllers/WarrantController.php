<?php

namespace App\Http\Controllers;

use App\Models\Warrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WarrantController extends Controller
{
    public function index()
    {
        $warrants = Warrant::latest()->paginate(10);
        return view('warrants.index', compact('warrants'));
    }

    public function create()
    {
        return view('warrants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warrant_number' => 'required|unique:warrants',
            'officer_name' => 'required|string|max:255',
            'station' => 'required|string|max:255',
            'phone_numbers' => 'required|array|min:1',
            'phone_numbers.*' => 'required|string|regex:/^[0-9+]+$/',
            'suspect_name' => 'nullable|string|max:255',
            'description' => 'required|string',
            'period_from' => 'required|date',
            'period_to' => 'required|date|after_or_equal:period_from',
            'cdr_file' => 'nullable|file|mimes:xlsx,xls,csv|max:10240',
            'kyc_file' => 'nullable|file|mimes:xlsx,xls,csv|max:10240'
        ]);

        // Handle file uploads
        if ($request->hasFile('cdr_file')) {
            $validated['cdr_file_path'] = $request->file('cdr_file')->store('cdr_files');
        }

        if ($request->hasFile('kyc_file')) {
            $validated['kyc_file_path'] = $request->file('kyc_file')->store('kyc_files');
        }

        Warrant::create($validated);

        return redirect()->route('warrants.index')
            ->with('success', 'Warrant created successfully.');
    }

    public function show(Warrant $warrant)
    {
        return view('warrants.show', compact('warrant'));
    }

    public function edit(Warrant $warrant)
    {
        return view('warrants.edit', compact('warrant'));
    }

    public function update(Request $request, Warrant $warrant)
    {
        $validated = $request->validate([
            'officer_name' => 'required|string|max:255',
            'station' => 'required|string|max:255',
            'phone_numbers' => 'required|array|min:1',
            'phone_numbers.*' => 'required|string|regex:/^[0-9+]+$/',
            'suspect_name' => 'nullable|string|max:255',
            'description' => 'required|string',
            'period_from' => 'required|date',
            'period_to' => 'required|date|after_or_equal:period_from',
            'status' => 'required|in:pending,processing,completed',
            'cdr_file' => 'nullable|file|mimes:xlsx,xls,csv|max:10240',
            'kyc_file' => 'nullable|file|mimes:xlsx,xls,csv|max:10240'
        ]);

        // Handle new file uploads
        if ($request->hasFile('cdr_file')) {
            // Delete old file if exists
            if ($warrant->cdr_file_path) {
                Storage::delete($warrant->cdr_file_path);
            }
            $validated['cdr_file_path'] = $request->file('cdr_file')->store('cdr_files');
        }

        if ($request->hasFile('kyc_file')) {
            // Delete old file if exists
            if ($warrant->kyc_file_path) {
                Storage::delete($warrant->kyc_file_path);
            }
            $validated['kyc_file_path'] = $request->file('kyc_file')->store('kyc_files');
        }

        $warrant->update($validated);

        return redirect()->route('warrants.show', $warrant)
            ->with('success', 'Warrant updated successfully.');
    }

    public function destroy(Warrant $warrant)
    {
        // Delete associated files
        if ($warrant->cdr_file_path) {
            Storage::delete($warrant->cdr_file_path);
        }
        if ($warrant->kyc_file_path) {
            Storage::delete($warrant->kyc_file_path);
        }

        $warrant->delete();

        return redirect()->route('warrants.index')
            ->with('success', 'Warrant deleted successfully.');
    }

    public function generateReport(Warrant $warrant)
    {
        // Simple report generation - you can expand this later
        return view('warrants.report', compact('warrant'));
    }
}
