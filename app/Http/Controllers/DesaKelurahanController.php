<?php

namespace App\Http\Controllers;

use App\Models\AdminApp;
use App\Models\DesaKelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DesaKelurahanController extends Controller
{
    public function tampil_data_desa_kelurahan_oleh_admin_app(){
        if (session()->has('LoggedAdminApp')){
            $data_admin_untuk_dashboard = AdminApp::where('id','=',session('LoggedAdminApp'))->first();
            $data_tabel = DB::table('desa_kelurahans')
                            ->join('kecamatans', 'desa_kelurahans.id_kecamatan', '=', 'kecamatans.id')
                            ->join('kabupatens', 'kecamatans.id_kabupaten', '=', 'kabupatens.id')
                            ->select('desa_kelurahans.id',
                                     'desa_kelurahans.kode_wilayah_desa_kelurahan',
                                     'desa_kelurahans.nama_desa_kelurahan',
                                     'kecamatans.nama_kecamatan',
                                     'kabupatens.nama_kabupaten')
                            ->orderBy('desa_kelurahans.id', 'asc')
                            ->get();
            $data = [
                'DataTabel'=>$data_tabel,
                'LoggedUserInfo'=>$data_admin_untuk_dashboard,
            ];
            return view('tampil_data_oleh_admin_app.tampil_data_desa_kelurahan_oleh_admin_app',$data);

        }else{
            return view('login.login_admin_app');
        }
    }

    public function cari_id_desa_kelurahan($id){
        $data = DesaKelurahan::find($id);
        return response()->json($data);
    }

    public function simpan_perubahan_data_kecamatan_pada_data_desa_kelurahan_oleh_admin_app(Request $request){
        $data_perubahan = DesaKelurahan::find($request->id);
        $data_perubahan->id_kecamatan = $request->id_kecamatan;
        $data_perubahan->save();
        return response()->json($data_perubahan);
    }

    public function simpan_perubahan_data_desa_kelurahan_oleh_admin_app(Request $request){
        $data_perubahan = DesaKelurahan::find($request->id);
        $data_perubahan->kode_wilayah_desa_kelurahan = $request->kode_wilayah_desa_kelurahan;
        $data_perubahan->nama_desa_kelurahan = $request->nama_desa_kelurahan;
        $data_perubahan->save();
        return response()->json($data_perubahan);
    }

    public function hapus_data_desa_kelurahan_oleh_admin_app(Request $request){
        $data_dihapus = DesaKelurahan::find($request->id);
        $data_dihapus->delete();
        return response()->json($data_dihapus);
    }

    public function tambah_data_desa_kelurahan_oleh_admin_app(){
        if (session()->has('LoggedAdminApp')){
            $data_admin_untuk_dashboard = AdminApp::where('id','=',session('LoggedAdminApp'))->first();
            $data_kecamatan=DB::table('kecamatans')
                                    ->select(
                                        'kecamatans.id',   
                                        'kecamatans.nama_kecamatan'
                                    )
                                    ->orderBy('kecamatans.id', 'asc')->get();
            $data = [
                'LoggedUserInfo'=>$data_admin_untuk_dashboard,
                'DataKecamatan'=>$data_kecamatan,
            ];
            return view('tambah_data_oleh_admin_app.tambah_data_desa_kelurahan_oleh_admin_app',$data);
        }else{
            return view('login.login_admin_app');
        }
    }

    public function simpan_data_desa_kelurahan_baru_oleh_admin_app(Request $request){
        if (session()->has('LoggedAdminApp')){
            $request->validate([
                'id_kecamatan'=>'required',
                'kode_wilayah_desa_kelurahan'=>'required|unique:desa_kelurahans',
                'nama_desa_kelurahan'=>'required',
            ],[
                'id_kecamatan.required'=>'Data tidak boleh kosong',
                'kode_wilayah_desa_kelurahan.required'=>'Kode tidak boleh kosong',
                'kode_wilayah_desa_kelurahan.unique'=>'Kode sudah digunakan',
                'nama_desa_kelurahan.required'=>'Nama tidak boleh kosong',
            ]);
            $data_baru = new DesaKelurahan();
            $data_baru->id_kecamatan = $request->id_kecamatan;
            $data_baru->kode_wilayah_desa_kelurahan = $request->kode_wilayah_desa_kelurahan;
            $data_baru->nama_desa_kelurahan = $request->nama_desa_kelurahan;
            $data_baru->save();
            $notification = array(
                'success' => 'Data sudah disimpan!',
            );
            return Redirect::to('tampil_data_desa_kelurahan_oleh_admin_app')->with($notification);
        }else{
            return view('login.login_admin_app');
        }
    }

}
