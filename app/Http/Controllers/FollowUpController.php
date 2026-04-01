<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FollowUp;
use App\Models\CalonKonsumen;

class FollowUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        $perPage = $request->query('per_page', 10);

        $query = FollowUp::with('calonKonsumen')
            ->when($q, function ($qq) use ($q) {
                $qq->whereHas('calonKonsumen', function ($c) use ($q) {
                    $c->where('nama', 'like', "%{$q}%")
                        ->orWhere('no_hp', 'like', "%{$q}%");
                });
            })
            ->latest('tgl_followup'); // sama dengan orderByDesc

        $items = ($perPage === 'all')
            ? $query->get()
            : $query->paginate((int) $perPage)->withQueryString();

        return view('pages.followup.index', compact('items'));
    }

    //   public function create(Request $request)
// {
//     $selectedCalonKonsumenId = $request->query('calon_konsumen_id'); // <- ganti ini

    //     $calonKonsumen = CalonKonsumen::orderBy('nama')->get();

    //     $selectedCalonKonsumen = null;
//     if ($selectedCalonKonsumenId) {
//         $selectedCalonKonsumen = CalonKonsumen::where('id', $selectedCalonKonsumenId)->first();
//     }

    //     return view('pages.followup.create', compact(
//         'calonKonsumen',
//         'selectedCalonKonsumenId',
//         'selectedCalonKonsumen'
//     ));
// }
    public function create(Request $request)
    {
        // kalau masuk dari halaman lain, gunakan query param: ?calon_konsumen_id=1
        $selectedCalonKonsumenId = $request->query('calon_konsumen_id');

        // pastikan ambil kolom id + nama (biar aman & ringan)
        $calonKonsumen = CalonKonsumen::select('id', 'nama')
            ->orderBy('nama')
            ->get();

        $selectedCalonKonsumen = null;
        if ($selectedCalonKonsumenId) {
            // karena PK-nya 'id', cukup pakai find()
            $selectedCalonKonsumen = CalonKonsumen::find($selectedCalonKonsumenId);
        }

        return view('pages.followup.create', compact(
            'calonKonsumen',
            'selectedCalonKonsumenId',
            'selectedCalonKonsumen'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'calon_konsumen_id' => ['required', 'integer', 'exists:calon_konsumen,id'],
            'tgl_followup' => ['required', 'date'],
            'respon_followup' => ['required', 'integer', 'in:1,2,3'],
            'catatan_followup' => ['nullable', 'string'],
        ]);

        FollowUp::create($validated);

        return redirect()
            ->route('follow-up.index')
            ->with('success', 'Follow up berhasil disimpan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $followUp = FollowUp::with('calonKonsumen')->findOrFail($id);

        return view('pages.followup.show', compact('followUp'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $followUp = FollowUp::findOrFail($id);
        $calonKonsumen = CalonKonsumen::orderBy('nama')->get();

        return view('pages.followup.edit', compact('followUp', 'calonKonsumen'));
    }

    public function update(Request $request, string $id)
    {
        $followUp = FollowUp::findOrFail($id);

        $validated = $request->validate([
            'calon_konsumen_id' => ['required', 'integer', 'exists:calon_konsumen,id'],
            'tgl_followup' => ['required', 'date'],
            'respon_followup' => ['required', 'in:1,2,3'],
            'catatan_followup' => ['nullable', 'string'],
        ]);

        $followUp->update($validated);

        return redirect()
            ->route('follow-up.index')
            ->with('success', 'Follow up berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $followUp = FollowUp::findOrFail($id);

        $followUp->delete();

        return redirect()
            ->route('follow-up.index')
            ->with('success', 'Data follow up berhasil dihapus.');
    }
}
