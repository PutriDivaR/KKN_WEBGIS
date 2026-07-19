<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\BerandaController;
use App\Http\Controllers\User\MapController;
use App\Http\Controllers\User\RumahController;
use App\Http\Controllers\User\FasilitasController;
use App\Http\Controllers\User\TentangController;
use App\Http\Controllers\User\PerancanganController;


use App\Http\Controllers\Admin\LoginController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminAktivitasController;
use App\Http\Controllers\Admin\AdminRumahController;
use App\Http\Controllers\Admin\AdminFasilitasController;
use App\Http\Controllers\Admin\AdminTentangController;

/* Ubah aja menyesuikan file yek*/

/* USER PUNYAA*/

Route::get('/', [BerandaController::class, 'index'])->name('home');

Route::get('/peta', [MapController::class, 'index'])->name('map');

Route::get('/peta/data', [MapController::class, 'data'])->name('map.data');

Route::get('/rumah/{slug}', [RumahController::class, 'show'])->name('rumah.show');

Route::get('/perancangan', [PerancanganController::class, 'index'])->name('perancangan.index');

Route::get('/perancangan/{slug}', [PerancanganController::class, 'show'])->name('perancangan.show');

Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');

Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');



/* LOGIN SI ADMIN*/

Route::get('/login', fn () => redirect()->route('admin.login'))
    ->name('login');

Route::get('/administrator/login', [LoginController::class, 'showLoginForm'])
    ->name('admin.login');

Route::post('/administrator/login', [LoginController::class, 'login']);

Route::post('/administrator/logout', [LoginController::class, 'logout'])
    ->name('admin.logout');


/* ADMIN PANEL */

Route::redirect('/administrator', '/administrator/dashboard');

Route::prefix('administrator')
    ->middleware('admin.session')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/profile', function () {
            return view('admin.profile', [
                'name' => session('admin_name', 'Admin Kampung Adat'),
                'email' => session('admin_email', 'admin@kampungadat.id'),
            ]);
        })->name('profile');

        Route::get('/aktivitas', [AdminAktivitasController::class, 'index'])
            ->name('aktivitas.index');

        Route::get('/detail-rumah-gadang', [AdminTentangController::class, 'index'])
            ->name('tentang.index');

        Route::resource('rumah', AdminRumahController::class);

        Route::resource('fasilitas', AdminFasilitasController::class);

        // NOTE: route tambahan untuk hapus 1 foto dari galeri fasilitas (dipakai di halaman edit)
        Route::delete('fasilitas-media/{media}', [AdminFasilitasController::class, 'destroyMedia'])
            ->name('fasilitas.media.destroy');
});
