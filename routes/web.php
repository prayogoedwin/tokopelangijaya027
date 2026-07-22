<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\Settings;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('dashboard');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::get('docs/instalasi-printer', function () {
    return view('docs.instalasiprinter');
})->name('docs.printer');

Route::middleware(['auth'])->group(function () {
    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
    Route::put('settings/appearance', [Settings\AppearanceController::class, 'update'])->name('settings.appearance.update');

    // Roles Management - dengan permission check
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:view-roles');
    Route::get('roles/export', [RoleController::class, 'export'])->name('roles.export')->middleware('permission:download-roles');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:create-roles');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:create-roles');
    Route::get('roles/{role}', [RoleController::class, 'show'])->name('roles.show')->middleware('permission:show-roles');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:edit-roles');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:edit-roles');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:delete-roles');

    // Permissions Management - dengan permission check
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:view-permissions');
    Route::get('permissions/export', [PermissionController::class, 'export'])->name('permissions.export')->middleware('permission:download-permissions');
    Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('permission:create-permissions');
    Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store')->middleware('permission:create-permissions');
    Route::get('permissions/{permission}', [PermissionController::class, 'show'])->name('permissions.show')->middleware('permission:show-permissions');
    Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('permission:edit-permissions');
    Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update')->middleware('permission:edit-permissions');
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('permission:delete-permissions');

    // Users Management - dengan permission check
    Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware('permission:view-users');
    Route::get('users/export', [UserController::class, 'export'])->name('users.export')->middleware('permission:download-users');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:create-users');
    Route::post('users', [UserController::class, 'store'])->name('users.store')->middleware('permission:create-users');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show')->middleware('permission:show-users');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:edit-users');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:edit-users');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:delete-users');

    // Tokos Management - dengan permission check
    Route::get('tokos', [TokoController::class, 'index'])->name('tokos.index')->middleware('permission:view-tokos');
    Route::get('tokos/export', [TokoController::class, 'export'])->name('tokos.export')->middleware('permission:download-tokos');
    Route::get('tokos/create', [TokoController::class, 'create'])->name('tokos.create')->middleware('permission:create-tokos');
    Route::post('tokos', [TokoController::class, 'store'])->name('tokos.store')->middleware('permission:create-tokos');
    Route::get('tokos/{toko}', [TokoController::class, 'show'])->name('tokos.show')->middleware('permission:show-tokos');
    Route::get('tokos/{toko}/edit', [TokoController::class, 'edit'])->name('tokos.edit')->middleware('permission:edit-tokos');
    Route::put('tokos/{toko}', [TokoController::class, 'update'])->name('tokos.update')->middleware('permission:edit-tokos');
    Route::delete('tokos/{toko}', [TokoController::class, 'destroy'])->name('tokos.destroy')->middleware('permission:delete-tokos');

    // Produk Management - dengan permission check
    Route::get('produks', [ProdukController::class, 'index'])->name('produks.index')->middleware('permission:view-produks');
    Route::get('produks/export', [ProdukController::class, 'export'])->name('produks.export')->middleware('permission:download-produks');
    Route::get('produks/create', [ProdukController::class, 'create'])->name('produks.create')->middleware('permission:create-produks');
    Route::post('produks/tambahstok/{produk}', [ProdukController::class, 'tambahstokstore'])->name('produks.tambahstokstore')->middleware('permission:create-produks');
    Route::post('produks', [ProdukController::class, 'store'])->name('produks.store')->middleware('permission:create-produks');
    Route::get('produks/{produk}', [ProdukController::class, 'show'])->name('produks.show')->middleware('permission:show-produks');
    Route::get('produks/{produk}/edit', [ProdukController::class, 'edit'])->name('produks.edit')->middleware('permission:edit-produks');
    Route::put('produks/{produk}', [ProdukController::class, 'update'])->name('produks.update')->middleware('permission:edit-produks');
    Route::delete('produks/{produk}', [ProdukController::class, 'destroy'])->name('produks.destroy')->middleware('permission:delete-produks');

    // Satuan Management - dengan permission check
    Route::get('satuans', [SatuanController::class, 'index'])->name('satuans.index')->middleware('permission:view-satuans');
    Route::get('satuans/export', [SatuanController::class, 'export'])->name('satuans.export')->middleware('permission:download-satuans');
    Route::get('satuans/create', [SatuanController::class, 'create'])->name('satuans.create')->middleware('permission:create-satuans');
    Route::post('satuans', [SatuanController::class, 'store'])->name('satuans.store')->middleware('permission:create-satuans');
    Route::get('satuans/{satuan}', [SatuanController::class, 'show'])->name('satuans.show')->middleware('permission:show-satuans');
    Route::get('satuans/{satuan}/edit', [SatuanController::class, 'edit'])->name('satuans.edit')->middleware('permission:edit-satuans');
    Route::put('satuans/{satuan}', [SatuanController::class, 'update'])->name('satuans.update')->middleware('permission:edit-satuans');
    Route::delete('satuans/{satuan}', [SatuanController::class, 'destroy'])->name('satuans.destroy')->middleware('permission:delete-satuans');

    // Kategori Management - dengan permission check
    Route::get('kategories', [KategoriController::class, 'index'])->name('kategories.index')->middleware('permission:view-kategories');
    Route::get('kategories/export', [KategoriController::class, 'export'])->name('kategories.export')->middleware('permission:download-kategories');
    Route::get('kategories/create', [KategoriController::class, 'create'])->name('kategories.create')->middleware('permission:create-kategories');
    Route::post('kategories', [KategoriController::class, 'store'])->name('kategories.store')->middleware('permission:create-kategories');
    Route::get('kategories/{kategori}', [KategoriController::class, 'show'])->name('kategories.show')->middleware('permission:show-kategories');
    Route::get('kategories/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategories.edit')->middleware('permission:edit-kategories');
    Route::put('kategories/{kategori}', [KategoriController::class, 'update'])->name('kategories.update')->middleware('permission:edit-kategories');
    Route::delete('kategories/{kategori}', [KategoriController::class, 'destroy'])->name('kategories.destroy')->middleware('permission:delete-kategories');

    // Stok Management - dengan permission check
    Route::get('stoks', [StokController::class, 'index'])->name('stoks.index')->middleware('permission:view-stoks');
    Route::get('stoksproduk/{produk}', [StokController::class, 'stokproduk'])->name('stoks.produk')->middleware('permission:view-stoks');

    Route::get('stoks/export', [StokController::class, 'export'])->name('stoks.export')->middleware('permission:download-stoks');
    Route::get('stoks/create', [StokController::class, 'create'])->name('stoks.create')->middleware('permission:create-stoks');
    Route::post('stoks', [StokController::class, 'store'])->name('stoks.store')->middleware('permission:create-stoks');
    Route::get('stoks/{stok}', [StokController::class, 'show'])->name('stoks.show')->middleware('permission:show-stoks');
    Route::get('stoks/{stok}/edit', [StokController::class, 'edit'])->name('stoks.edit')->middleware('permission:edit-stoks');
    Route::put('stoks/{stok}', [StokController::class, 'update'])->name('stoks.update')->middleware('permission:edit-stoks');
    Route::delete('stoks/{stok}', [StokController::class, 'destroy'])->name('stoks.destroy')->middleware('permission:delete-stoks');



    // Route untuk kasir tanpa middleware (untuk pilih toko)
    Route::get('/kasir/pilihtoko', [KasirController::class, 'pilihToko'])->name('kasir.pilihtoko');
    Route::post('/kasir/simpantoko', [KasirController::class, 'simpanPilihanToko'])->name('kasir.simpantoko');


    Route::get('/kasir/uipilihtoko', [KasirController::class, 'kasir_pilihtoko'])->name('kasir.kasir_pilihToko');
    Route::post('/kasir/uisimpantoko', [KasirController::class, 'kasir_simpanPilihanToko'])->name('kasir.kasir_simpantoko');


    // Route untuk kasir yang sudah punya session toko
    Route::middleware(['checkSelectedToko'])->group(function () {
        Route::get('/kasir/dashboard', [KasirController::class, 'dashboard'])->name('kasir.dashboard')->middleware('permission:kasir');
        Route::post('/kasir/exittoko', [KasirController::class, 'exitToko'])->name('kasir.exittoko')->middleware('permission:kasir');

        Route::post('/kasir/kasir_exittoko', [KasirController::class, 'kasir_exitToko'])->name('kasir.kasir_exittoko')->middleware('permission:kasir');

        //Route khusus Login kasir
        Route::get('/kasir/ui', [KasirController::class, 'kasir_dashboard'])->name('kasir.kasir_dashboard');
        Route::get('/kasir/cekstok', [KasirController::class, 'kasir_cekstok'])->name('kasir.kasir_cekstok');
        Route::get('/kasir/cekpenjualan', [KasirController::class, 'kasir_cekpenjualan'])->name('kasir.kasir_cekpenjualan');
        Route::get('/kasir/cekpenjualan/{penjualan}', [KasirController::class, 'kasir_showpenjualan'])->name('kasir.kasir_showpenjualan');
        Route::get('/kasir/ceklaporan', [KasirController::class, 'kasir_ceklaporan'])->name('kasir.kasir_ceklaporan');


        Route::post('/kasir/process-payment', [KasirController::class, 'processPayment'])->name('kasir.processpayment')->middleware('permission:kasir');

        Route::post('/kasir/uiprocess-payment', [KasirController::class, 'kasir_processPayment'])->name('kasir.kasir_processpayment')->middleware('permission:kasir');

        // Route kasir lainnya (transaksi, dll)
        // Route::get('/kasir/transaksi', ...);
    });

    // Stok Management - dengan permission check
    Route::get('penjualans', [PenjualanController::class, 'index'])->name('penjualans.index')->middleware('permission:view-penjualans');
    Route::get('penjualans/export', [PenjualanController::class, 'export'])->name('penjualans.export')->middleware('permission:download-penjualans');
    Route::get('penjualans/create', [PenjualanController::class, 'create'])->name('penjualans.create')->middleware('permission:create-penjualans');
    Route::post('penjualans', [PenjualanController::class, 'store'])->name('penjualans.store')->middleware('permission:create-penjualans');
    Route::get('penjualans/{penjualan}', [PenjualanController::class, 'show'])->name('penjualans.show')->middleware('permission:show-penjualans');
    Route::get('penjualans/{penjualan}/cetaknota', [PenjualanController::class, 'cetakNota'])->name('penjualans.cetaknota')->middleware('permission:kasir');
    Route::get('penjualans/{penjualan}/printthermal', [PenjualanController::class, 'printThermal'])->name('penjualans.printthermal')->middleware('permission:kasir');
    Route::get('penjualans/{penjualan}/kirimwa', [PenjualanController::class, 'kirimwa'])->name('penjualans.kirimwa')->middleware('permission:kasir');
    Route::get('penjualans/{penjualan}/edit', [PenjualanController::class, 'edit'])->name('penjualans.edit')->middleware('permission:edit-penjualans');
    Route::put('penjualans/{penjualan}', [PenjualanController::class, 'update'])->name('penjualans.update')->middleware('permission:edit-penjualans');
    Route::delete('penjualans/{penjualan}', [PenjualanController::class, 'destroy'])->name('penjualans.destroy')->middleware('permission:delete-penjualans');

    //Laporans
    Route::get('laporans/penjualan', [LaporanPenjualanController::class, 'index'])->name('laporans.penjualan')->middleware('permission:view-laporanpenjualans');
    Route::get('laporans/penjualan/export', [LaporanPenjualanController::class, 'export'])->name('laporans.penjualan.export')->middleware('permission:view-laporanpenjualans');
});

require __DIR__ . '/auth.php';
