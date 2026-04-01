<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\CalonKonsumen;
use App\Models\Followup;
use App\Models\Survei;


class DashboardController extends Controller
{
    public function index()
    {
        // 1) Training
        $totalTraining = Training::count();

        // 2) Calon Konsumen
        $totalCalon = CalonKonsumen::count();

        // 3) Follow Up
        $totalFollowup = Followup::count();

        // 4) Survei (semua data survei, bukan cuma "Ya")
        $totalSurvei = Survei::count();

        // 5) Prediksi
        // $totalPrediksi = Prediksi::count();

        // // Split prediksi: Membeli vs Tidak Membeli
        // // Asumsi nama kolom di tabel prediksis: "hasil" atau "keputusan"
        // $prediksiMembeli = Prediksi::where('hasil', 'Membeli')
        //     ->orWhere('keputusan', 'Membeli')
        //     ->count();

        // $prediksiTidakMembeli = Prediksi::where('hasil', 'Tidak Membeli')
        //     ->orWhere('keputusan', 'Tidak Membeli')
        //     ->count();

        return view('pages.dashboard.dashboard', compact(
            'totalTraining',
            'totalCalon',
            'totalFollowup',
            'totalSurvei',
            // 'totalPrediksi',
            // 'prediksiMembeli',
            // 'prediksiTidakMembeli'
        ));
    }
}

