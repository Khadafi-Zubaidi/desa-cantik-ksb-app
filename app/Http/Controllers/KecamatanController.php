<?php

namespace App\Http\Controllers;

use App\Models\AdminApp;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KecamatanController extends Controller
{
    public function tampil_data_kecamatan_oleh_admin_app(){
        if (session()->has('LoggedAdminApp')){
            $data_admin_untuk_dashboard = AdminApp::where('id','=',session('LoggedAdminApp'))->first();
            $data_tabel = DB::table('kecamatans')
                            ->join('kabupatens', 'kecamatans.id_kabupaten', '=', 'kabupatens.id')
                            ->select('kecamatans.id',
                                     'kecamatans.kode_wilayah_kecamatan',
                                     'kecamatans.nama_kecamatan',
                                     'kabupatens.nama_kabupaten')
                            ->orderBy('kecamatans.id', 'asc')
                            ->get();
            $data = [
                'DataTabel'=>$data_tabel,
                'LoggedUserInfo'=>$data_admin_untuk_dashboard,
            ];
            return view('tampil_data_oleh_admin_app.tampil_data_kecamatan_oleh_admin_app',$data);

        }else{
            return view('login.login_admin_app');
        }
    }

    public function cari_id_kecamatan($id){
        $data = Kecamatan::find($id);
        return response()->json($data);
    }

    public function simpan_perubahan_data_kabupaten_pada_data_kecamatan_oleh_admin_app(Request $request){
        $data_perubahan = Kecamatan::find($request->id);
        $data_perubahan->id_kabupaten = $request->id_kabupaten;
        $data_perubahan->save();
        return response()->json($data_perubahan);
    }

    public function simpan_perubahan_data_kecamatan_oleh_admin_app(Request $request){
        $data_perubahan = Kecamatan::find($request->id);
        $data_perubahan->kode_wilayah_kecamatan = $request->kode_wilayah_kecamatan;
        $data_perubahan->nama_kecamatan = $request->nama_kecamatan;
        $data_perubahan->save();
        return response()->json($data_perubahan);
    }

    public function hapus_data_kecamatan_oleh_admin_app(Request $request){
        $data_dihapus = Kecamatan::find($request->id);
        $data_dihapus->delete();
        return response()->json($data_dihapus);
    }

    public function tambah_data_kecamatan_oleh_admin_app(){
        if (session()->has('LoggedAdminApp')){
            $data_admin_untuk_dashboard = AdminApp::where('id','=',session('LoggedAdminApp'))->first();
            $data_kabupaten=DB::table('kabupatens')
                                    ->select(
                                        'kabupatens.id',   
                                        'kabupatens.nama_kabupaten'
                                    )
                                    ->orderBy('kabupatens.id', 'asc')->get();
            $data = [
                'LoggedUserInfo'=>$data_admin_untuk_dashboard,
                'DataKabupaten'=>$data_kabupaten,
            ];
            return view('tambah_data_oleh_admin_app.tambah_data_kecamatan_oleh_admin_app',$data);
        }else{
            return view('login.login_admin_app');
        }
    }

    public function simpan_data_kecamatan_baru_oleh_admin_app(Request $request){
        if (session()->has('LoggedAdminApp')){
            $request->validate([
                'id_kabupaten'=>'required',
                'kode_wilayah_kecamatan'=>'required|unique:kecamatans',
                'nama_kecamatan'=>'required',
            ],[
                'id_kabupaten.required'=>'Data tidak boleh kosong',
                'kode_wilayah_kecamatan.required'=>'Kode tidak boleh kosong',
                'kode_wilayah_kecamatan.unique'=>'Kode sudah digunakan',
                'nama_kecamatan.required'=>'Nama tidak boleh kosong',
            ]);
            $data_baru = new Kecamatan();
            $data_baru->id_kabupaten = $request->id_kabupaten;
            $data_baru->kode_wilayah_kecamatan = $request->kode_wilayah_kecamatan;
            $data_baru->nama_kecamatan = $request->nama_kecamatan;
            $data_baru->save();
            $notification = array(
                'success' => 'Data sudah disimpan!',
            );
            return Redirect::to('tampil_data_kecamatan_oleh_admin_app')->with($notification);
        }else{
            return view('login.login_admin_app');
        }
    }
}
