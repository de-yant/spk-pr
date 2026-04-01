<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalonKonsumen;
use App\Models\Survei;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SurveiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $q = $request->query('q');
        $perPage = $request->query('per_page', 10);

        $query = Survei::with('calonKonsumen')
            ->when($q, function ($qq) use ($q) {
                $qq->whereHas('calonKonsumen', function ($c) use ($q) {
                    $c->where('nama', 'like', "%{$q}%")
                        ->orWhere('no_hp', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('tgl_survei');

        if ($perPage === 'all') {
            $items = $query->get();
        } else {
            $items = $query->paginate((int) $perPage)->withQueryString();
        }

        return view('pages.survei.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // kalau masuk dari detail konsumen: /follow-up/create?id=xx
        $selectedCalonKonsumenId = $request->query('id');

        $calonKonsumen = CalonKonsumen::orderBy('nama')->get();

        $selectedCalonKonsumen = null;
        if ($selectedCalonKonsumenId) {
            $selectedCalonKonsumen = CalonKonsumen::find($selectedCalonKonsumenId);
        }

        return view('pages.survei.create', compact(
            'calonKonsumen',
            'selectedCalonKonsumenId',
            'selectedCalonKonsumen'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'calon_konsumen_id' => ['required', 'integer', 'exists:calon_konsumen,id'],
            'survei' => ['required', 'integer', 'in:1,2'],
            'tgl_survei' => ['required', 'date'],
            'hasil_survei' => ['required', 'string', 'max:30'],
            'catatan_survei' => ['nullable', 'string'],
        ]);

        try {
            $row = Survei::create($validated);

            Log::info('SURVEI CREATED', [
                'id_survei' => $row->id_survei,
                'db' => DB::connection()->getDatabaseName(),
                'data' => $validated,
            ]);

            return redirect()
                ->route('survei.index')
                ->with('success', 'Data survei berhasil disimpan. ID: ' . $row->id_survei);
        } catch (\Throwable $e) {
            Log::error('SURVEI CREATE FAILED', [
                'message' => $e->getMessage(),
                'db' => DB::connection()->getDatabaseName(),
            ]);

            return back()->withInput()->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Survei::with('calonKonsumen')->findOrFail($id);
        return view('pages.survei.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Survei::findOrFail($id);
        $calonKonsumen = CalonKonsumen::orderBy('nama')->get();

        return view('pages.survei.edit', compact('item', 'calonKonsumen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Survei::findOrFail($id);

        $validated = $request->validate([
            'calon_konsumen_id' => ['required', 'integer', 'exists:calon_konsumen,id'],
            'survei' => ['required', 'integer', 'in:1,2'],
            'tgl_survei' => ['required', 'date'],
            'hasil_survei' => ['required', 'string', 'max:30'],
            'catatan_survei' => ['nullable', 'string'],
        ]);

        try {
            $item->update($validated);

            return redirect()
                ->route('survei.index')
                ->with('success', 'Data survei berhasil diperbarui.');
        } catch (\Throwable $e) {
            \Log::error('SURVEI UPDATE FAILED', [
                'id_survei' => $id,
                'message' => $e->getMessage(),
                'db' => \DB::connection()->getDatabaseName(),
            ]);

            return back()->withInput()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Survei::findOrFail($id);

        try {
            $item->delete();

            return redirect()
                ->route('survei.index')
                ->with('success', 'Data survei berhasil dihapus.');
        } catch (\Throwable $e) {
            Log::error('SURVEI DELETE FAILED', [
                'id_survei' => $id,
                'message' => $e->getMessage(),
                'db' => DB::connection()->getDatabaseName(),
            ]);

            return back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}
