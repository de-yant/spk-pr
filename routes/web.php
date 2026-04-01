<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IdentitasController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\SurveiController;
use App\Http\Controllers\TrainingController;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('pages.dashboard.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])
    ->prefix('calon-konsumen')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | IDENTITAS
        |--------------------------------------------------------------------------
        */
        Route::prefix('identitas')
            ->name('identitas.')
            ->group(function () {

                Route::get('/', [IdentitasController::class, 'index'])->name('index');
                Route::get('/create', [IdentitasController::class, 'create'])->name('create');
                Route::post('/', [IdentitasController::class, 'store'])->name('store');
                Route::get('/{identitas}', [IdentitasController::class, 'show'])->name('show');
                Route::get('/{identitas}/edit', [IdentitasController::class, 'edit'])->name('edit');
                Route::match(['put', 'patch'], '/{identitas}', [IdentitasController::class, 'update'])->name('update');
                Route::delete('/{identitas}', [IdentitasController::class, 'destroy'])->name('destroy');
            });


        /*
        |--------------------------------------------------------------------------
        | FOLLOW UP
        |--------------------------------------------------------------------------
        */
        Route::prefix('follow-up')
            ->name('follow-up.')
            ->group(function () {

                Route::get('/', [FollowUpController::class, 'index'])->name('index');
                Route::get('/create', [FollowUpController::class, 'create'])->name('create');
                Route::post('/', [FollowUpController::class, 'store'])->name('store');
                Route::get('/{follow_up}', [FollowUpController::class, 'show'])->name('show');
                Route::get('/{follow_up}/edit', [FollowUpController::class, 'edit'])->name('edit');
                Route::put('/{follow_up}', [FollowUpController::class, 'update'])->name('update');
                Route::delete('/{follow_up}', [FollowUpController::class, 'destroy'])->name('destroy');
            });


        /*
        |--------------------------------------------------------------------------
        | SURVEI
        |--------------------------------------------------------------------------
        */
        Route::prefix('survei')
            ->name('survei.')
            ->group(function () {

                Route::get('/', [SurveiController::class, 'index'])->name('index');
                Route::get('/create', [SurveiController::class, 'create'])->name('create');
                Route::post('/', [SurveiController::class, 'store'])->name('store');
                Route::get('/{survei}', [SurveiController::class, 'show'])->name('show');
                Route::get('/{survei}/edit', [SurveiController::class, 'edit'])->name('edit');
                Route::put('/{survei}', [SurveiController::class, 'update'])->name('update');
                Route::delete('/{survei}', [SurveiController::class, 'destroy'])->name('destroy');
            });


        /*
        |--------------------------------------------------------------------------
        | PREDIKSI
        |--------------------------------------------------------------------------
        */
        Route::prefix('prediksi')
            ->name('prediksi.')
            ->group(function () {

                Route::get('/', [PrediksiController::class, 'index'])->name('index');
                Route::get('/create', [PrediksiController::class, 'create'])->name('create');
                Route::post('/', [PrediksiController::class, 'store'])->name('store');
                Route::get('/{prediksi}', [PrediksiController::class, 'show'])->name('show');
                Route::get('/{prediksi}/edit', [PrediksiController::class, 'edit'])->name('edit');
                Route::put('/{prediksi}', [PrediksiController::class, 'update'])->name('update');
                Route::delete('/{prediksi}', [PrediksiController::class, 'destroy'])->name('destroy');
            });

        Route::post('/training/import', [TrainingController::class, 'import'])
            ->name('training.import');

    });

