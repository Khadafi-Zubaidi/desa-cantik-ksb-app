<?php

use App\Http\Controllers\AdminAppController;
use App\Http\Controllers\DesaKelurahanController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Models\DesaKelurahan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Admin App
Route::get('register_admin_app',[AdminAppController::class,'register_admin_app'])->name('register_admin_app');
Route::post('simpan_data_admin_app_baru',[AdminAppController::class,'simpan_data_admin_app_baru'])->name('simpan_data_admin_app_baru');
Route::get('login_admin_app',[AdminAppController::class,'login_admin_app'])->middleware('AdminAppLoggedIn');
Route::post('cek_login_admin_app',[AdminAppController::class,'cek_login_admin_app'])->name('cek_login_admin_app');
Route::get('dashboard_admin_app',[AdminAppController::class,'dashboard_admin_app'])->name('dashboard_admin_app');
Route::get('logout_admin_app',[AdminAppController::class,'logout_admin_app'])->name('logout_admin_app');
Route::get('tampil_data_profil_admin_app_oleh_admin_app',[AdminAppController::class,'tampil_data_profil_admin_app_oleh_admin_app'])->name('tampil_data_profil_admin_app_oleh_admin_app');
Route::post('simpan_perubahan_data_profil_admin_app',[AdminAppController::class,'simpan_perubahan_data_profil_admin_app'])->name('simpan_perubahan_data_profil_admin_app');
Route::post('simpan_perubahan_data_password_admin_app',[AdminAppController::class,'simpan_perubahan_data_password_admin_app'])->name('simpan_perubahan_data_password_admin_app');
Route::post('simpan_perubahan_data_foto_admin_app',[AdminAppController::class,'simpan_perubahan_data_foto_admin_app'])->name('simpan_perubahan_data_foto_admin_app');

//Kabupaten
Route::get('tampil_data_kabupaten_oleh_admin_app',[KabupatenController::class,'tampil_data_kabupaten_oleh_admin_app'])->name('tampil_data_kabupaten_oleh_admin_app');
Route::get('/cari_id_kabupaten/{id}',[KabupatenController::class,'cari_id_kabupaten']);
Route::put('/simpan_perubahan_data_kabupaten_oleh_admin_app',[KabupatenController::class,'simpan_perubahan_data_kabupaten_oleh_admin_app'])->name('kabupaten.simpan_perubahan_data');
Route::put('/hapus_data_kabupaten_oleh_admin_app',[KabupatenController::class,'hapus_data_kabupaten_oleh_admin_app'])->name('kabupaten.hapus_data');
Route::get('tambah_data_kabupaten_oleh_admin_app',[KabupatenController::class,'tambah_data_kabupaten_oleh_admin_app'])->name('tambah_data_kabupaten_oleh_admin_app');
Route::post('simpan_data_kabupaten_baru_oleh_admin_app',[KabupatenController::class,'simpan_data_kabupaten_baru_oleh_admin_app'])->name('simpan_data_kabupaten_baru_oleh_admin_app');
Route::get('/tampil_data_kabupaten_untuk_pilihan',[KabupatenController::class,'tampil_data_kabupaten_untuk_pilihan'])->name('tampil_data_kabupaten_untuk_pilihan');

//Kecamatan
Route::get('tampil_data_kecamatan_oleh_admin_app',[KecamatanController::class,'tampil_data_kecamatan_oleh_admin_app'])->name('tampil_data_kecamatan_oleh_admin_app');
Route::get('/cari_id_kecamatan/{id}',[KecamatanController::class,'cari_id_kecamatan']);
Route::put('/simpan_perubahan_data_kabupaten_pada_data_kecamatan_oleh_admin_app',[KecamatanController::class,'simpan_perubahan_data_kabupaten_pada_data_kecamatan_oleh_admin_app'])->name('kecamatan.simpan_perubahan_data_kabupaten');
Route::put('/simpan_perubahan_data_kecamatan_oleh_admin_app',[KecamatanController::class,'simpan_perubahan_data_kecamatan_oleh_admin_app'])->name('kecamatan.simpan_perubahan_data');
Route::put('/hapus_data_kecamatan_oleh_admin_app',[KecamatanController::class,'hapus_data_kecamatan_oleh_admin_app'])->name('kecamatan.hapus_data');
Route::get('tambah_data_kecamatan_oleh_admin_app',[KecamatanController::class,'tambah_data_kecamatan_oleh_admin_app'])->name('tambah_data_kecamatan_oleh_admin_app');
Route::post('simpan_data_kecamatan_baru_oleh_admin_app',[KecamatanController::class,'simpan_data_kecamatan_baru_oleh_admin_app'])->name('simpan_data_kecamatan_baru_oleh_admin_app');
Route::get('/tampil_data_kecamatan_untuk_pilihan',[KecamatanController::class,'tampil_data_kecamatan_untuk_pilihan'])->name('tampil_data_kecamatan_untuk_pilihan');

//Desa / Kelurahan
Route::get('tampil_data_desa_kelurahan_oleh_admin_app',[DesaKelurahanController::class,'tampil_data_desa_kelurahan_oleh_admin_app'])->name('tampil_data_desa_kelurahan_oleh_admin_app');
Route::get('/cari_id_desa_kelurahan/{id}',[DesaKelurahanController::class,'cari_id_desa_kelurahan']);
Route::put('/simpan_perubahan_data_kecamatan_pada_data_desa_kelurahan_oleh_admin_app',[DesaKelurahanController::class,'simpan_perubahan_data_kecamatan_pada_data_desa_kelurahan_oleh_admin_app'])->name('desa_kelurahan.simpan_perubahan_data_kecamatan');
Route::put('/simpan_perubahan_data_desa_kelurahan_oleh_admin_app',[DesaKelurahanController::class,'simpan_perubahan_data_desa_kelurahan_oleh_admin_app'])->name('desa_kelurahan.simpan_perubahan_data');
Route::put('/hapus_data_desa_kelurahan_oleh_admin_app',[DesaKelurahanController::class,'hapus_data_desa_kelurahan_oleh_admin_app'])->name('desa_kelurahan.hapus_data');
Route::get('tambah_data_desa_kelurahan_oleh_admin_app',[DesaKelurahanController::class,'tambah_data_desa_kelurahan_oleh_admin_app'])->name('tambah_data_desa_kelurahan_oleh_admin_app');
Route::post('simpan_data_desa_kelurahan_baru_oleh_admin_app',[DesaKelurahanController::class,'simpan_data_desa_kelurahan_baru_oleh_admin_app'])->name('simpan_data_desa_kelurahan_baru_oleh_admin_app');

