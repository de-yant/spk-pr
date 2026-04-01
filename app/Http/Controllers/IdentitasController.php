<?php

namespace App\Http\Controllers;

use App\Models\CalonKonsumen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IdentitasController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q; // search
        $perPage = $request->per_page ?? 10;

        $query = CalonKonsumen::query()
            ->when($q, function ($qq) use ($q) {
                $qq->where('nama', 'like', "%{$q}%")
                    ->orWhere('no_hp', 'like', "%{$q}%");
            })
            ->orderByDesc('id_calon_konsumen');

        if ($perPage === 'all') {
            $items = $query->get();
        } else {
            $items = $query->paginate((int) $perPage)->withQueryString();
        }

        return view('pages.identitas.index', [
            'items' => $items,
            'title' => 'Identitas Calon Konsumen',
        ]);
    }

    public function create()
    {
        return view('pages.identitas.create', [
            'title' => 'Tambah Identitas Calon Konsumen',
        ]);
    }
    public function store(Request $request)
{
    $hargaByTipe = [
        '30/60' => 304000000,
        '36/72' => 364000000,
        '42/72' => 408000000,
    ];

    $cicilanByTipe = [
        '30/60' => 2300000,
        '36/72' => 3000000,
        '42/72' => 4000000,
    ];

    $dpPercentDefault = 0.10;

    $validated = $request->validate([
        'nama' => 'required|string|max:50',
        'no_hp' => 'required|string|max:15|unique:calon_konsumen,no_hp',

        'usia' => 'required|integer|min:17|max:100',
        'pekerjaan' => 'required|string|max:30',
        'penghasilan' => 'required|integer|min:0',

        // frontend kirim angka
        'status_nikah' => 'required|integer|in:1,2,3,4',
        'tanggungan' => 'required|integer|min:0|max:20',

        'tipe' => 'required|in:30/60,36/72,42/72',

        // frontend kirim angka
        'lokasi' => 'required|integer|in:1,2,3,4',
        'bi' => 'required|integer|in:1,2',
        'metode' => 'required|integer|in:1,2,3',

        'kunjungan' => 'required|integer|min:0|max:10',
    ]);

    $tipe = $validated['tipe'];
    $metode = (int) $validated['metode']; // 1=KPR, 2=Cash Bertahap, 3=Cash Keras

    // auto harga
    $validated['harga'] = $hargaByTipe[$tipe];

    // auto cicilan + dp
    if (in_array($metode, [1, 2], true)) { // KPR / Cash Bertahap
        $validated['cicilan'] = $cicilanByTipe[$tipe];
        $validated['dp'] = (int) round($validated['harga'] * $dpPercentDefault);
    } else { // Cash Keras
        $validated['cicilan'] = 0;
        $validated['dp'] = $validated['harga'];
    }

    CalonKonsumen::create($validated);

    return redirect()->route('identitas.index')
        ->with('success', 'Data calon konsumen berhasil ditambahkan.');
}
    public function show(CalonKonsumen $identitas)
    {
        return view('pages.identitas.show', [
            'title' => 'Detail Identitas Calon Konsumen',
            'item' => $identitas,
        ]);
    }

    public function edit(CalonKonsumen $identitas)
    {
        return view('pages.identitas.edit', [
            'title' => 'Edit Identitas Calon Konsumen',
            'item' => $identitas,
        ]);
    }

    // public function update(Request $request, CalonKonsumen $identitas)
    // {
    //     $validated = $request->validate([
    //         'nama' => 'required|string|max:30',
    //         'no_hp' => 'required|string|max:15',

    //         'usia' => 'nullable|integer|min:0',
    //         'pekerjaan' => 'nullable|string|max:50',
    //         'penghasilan' => 'nullable|numeric',

    //         'pernikahan' => 'nullable|string|max:20',
    //         'tanggungan' => 'nullable|integer|min:0',

    //         'harga_rumah' => 'nullable|numeric',
    //         'type_rumah' => 'nullable|string|max:30',
    //         'lokasi' => 'nullable|string|max:50',

    //         'status_bi_checking' => 'nullable|string|max:30',
    //         'metode_pembayaran' => 'nullable|string|max:30',

    //         'uang_muka' => 'nullable|numeric',
    //         'cicilan' => 'nullable|numeric',

    //         'kunjungan' => 'nullable|integer|min:0|max:10',

    //         'dana_darurat' => 'nullable|string|max:30',
    //         'rencana_hunian' => 'nullable|string|max:50',
    //         'kepemilikan_rumah' => 'nullable|string|max:50',
    //     ]);

    //     $identitas->update($validated);

    //     return redirect()->route('identitas.index')
    //         ->with('success', 'Data berhasil diperbarui.');
    // }

    public function update(Request $request, CalonKonsumen $identitas)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:30',
            'no_hp' => 'required|string|max:15',

            'usia' => 'nullable|integer|min:0',
            'pekerjaan' => 'nullable|string|max:50',
            'penghasilan' => 'nullable|numeric',

            'status_nikah' => 'nullable|string|max:20',
            'tanggungan' => 'nullable|integer|min:0',

            'harga' => 'nullable|numeric',
            'tipe' => 'nullable|string|max:30',
            'lokasi' => 'nullable|string|max:50',

            'bi' => 'nullable|string|max:30',
            'metode' => 'nullable|string|max:30',

            'dp' => 'nullable|numeric',
            'cicilan' => 'nullable|numeric',

            'kunjungan' => 'nullable|integer|min:0|max:10',

            'respon' => 'nullable|string|max:30',
            'survei' => 'nullable|string|max:30',
        ]);

        $identitas->update($validated);

        return redirect()->route('identitas.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(CalonKonsumen $identitas)
    {
        $identitas->delete();

        return redirect()->route('identitas.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
