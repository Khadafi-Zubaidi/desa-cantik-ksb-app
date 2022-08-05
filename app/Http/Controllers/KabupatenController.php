<?php

namespace App\Http\Controllers;

use App\Models\AdminApp;
use App\Models\Kabupaten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KabupatenController extends Controller
{
    public function tampil_data_kabupaten_oleh_admin_app(){
        if (session()->has('LoggedAdminApp')){
            $data_admin_untuk_dashboard = AdminApp::where('id','=',session('LoggedAdminApp'))->first();
            $data_tabel = Kabupaten::orderBy('id', 'desc')->get();
            $data = [
                'LoggedUserInfo'=>$data_admin_untuk_dashboard,
                'DataTabel'=>$data_tabel,
            ];
            return view('tampil_data_oleh_admin_app.tampil_data_kabupaten_oleh_admin_app',$data);
        }else{
            return view('login.login_admin_app');
        }
    }

    public function cari_id_kabupaten($id){
        $data = Kabupaten::find($id);
        return response()->json($data);
    }

    public function simpan_perubahan_data_kabupaten_oleh_admin_app(Request $request){
        $data_perubahan = Kabupaten::find($request->id);
        $data_perubahan->kode_wilayah_kabupaten = $request->kode_wilayah_kabupaten;
        $data_perubahan->nama_kabupaten = $request->nama_kabupaten;
        $data_perubahan->save();
        return response()->json($data_perubahan);
    }

    public function hapus_data_kabupaten_oleh_admin_app(Request $request){
        $data_dihapus = Kabupaten::find($request->id);
        $data_dihapus->delete();
        return response()->json($data_dihapus);
    }

    public function tambah_data_kabupaten_oleh_admin_app(){
        if (session()->has('LoggedAdminApp')){
            $data_admin_untuk_dashboard = AdminApp::where('id','=',session('LoggedAdminApp'))->first();
            $data = [
                'LoggedUserInfo'=>$data_admin_untuk_dashboard,
            ];
            return view('tambah_data_oleh_admin_app.tambah_data_kabupaten_oleh_admin_app',$data);
        }else{
            return view('login.login_admin_app');
        }
    }

    public function simpan_data_kabupaten_baru_oleh_admin_app(Request $request){
        if (session()->has('LoggedAdminApp')){
            $request->validate([
                'kode_wilayah_kabupaten'=>'required|unique:kabupatens',
                'nama_kabupaten'=>'required',
            ],[
                'kode_wilayah_kabupaten.required'=>'Kode tidak boleh kosong',
                'kode_wilayah_kabupaten.unique'=>'Kode sudah digunakan',
                'nama_kabupaten.required'=>'Nama tidak boleh kosong',
            ]);
            $data_baru = new Kabupaten();
            $data_baru->kode_wilayah_kabupaten = $request->kode_wilayah_kabupaten;
            $data_baru->nama_kabupaten = $request->nama_kabupaten;
            $data_baru->save();
            $notification = array(
                'success' => 'Data sudah disimpan!',
            );
            return Redirect::to('tampil_data_kabupaten_oleh_admin_app')->with($notification);
        }else{
            return view('login.login_admin_app');
        }
    }

    public function tampil_data_kabupaten_untuk_pilihan(){
        $data_kabupaten = DB::table('kabupatens')
                            ->pluck('id','nama_kabupaten');
        return response()->json($data_kabupaten);
    }


}
