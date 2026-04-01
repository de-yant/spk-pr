<?php

namespace App\Http\Controllers;
use App\Imports\TrainingImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

   public function import(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls|max:5120', // max 5MB (ubah kalau mau)
    ], [
        'file.required' => 'File wajib diupload.',
        'file.mimes'    => 'Format file harus .xlsx atau .xls',
        'file.max'      => 'Ukuran file terlalu besar (maks 5MB).',
    ]);

    try {
        // Import langsung (TrainingImport akan lempar exception kalau ada nilai/kode tidak valid)
        Excel::import(new TrainingImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data berhasil diimport!');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        // Kalau kamu nanti pakai WithValidation di import, ini menangkap error per-baris
        $failures = $e->failures();

        $msg = "Import gagal. Detail error:\n";
        foreach ($failures as $failure) {
            $msg .= "Baris {$failure->row()}: " . implode(', ', $failure->errors()) . "\n";
        }

        return redirect()->back()->with('error', $msg);
    } catch (\Throwable $e) {
        // Tangkap semua error lain (termasuk exception custom dari TrainingImport)
        return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage());
    }
}
}
