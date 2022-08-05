<?php

namespace App\Http\Controllers;

use App\Models\AdminApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AdminAppController extends Controller
{
    public function register_admin_app(){
        return view('register.register_admin_app');
    }

    public function simpan_data_admin_app_baru(Request $request){
        $request->validate([
            'nip_admin_app'=>'required|unique:admin_apps',
            'nama_admin_app'=>'required',
            'password_admin_app'=>'required',
        ],[
            'nip_admin_app.required'=>'NIP tidak boleh kosong',
            'nama_admin_app.required'=>'Nama tidak boleh kosong',
            'password_admin_app.required'=>'Password tidak boleh kosong',
        ]);
        $data_baru = new AdminApp();
        $data_baru->nip_admin_app = $request->nip_admin_app;
        $data_baru->nama_admin_app = $request->nama_admin_app;
        $data_baru->password_admin_app = Hash::make($request->password_admin_app);
        $data_baru->save();
        $notification = array(
            'success' => 'Data Admin '.$request->nama_admin_app.' berhasil disimpan!',
        );
        return Redirect::to('register_admin_app')->with($notification);
    }

    public function login_admin_app(){
        return view('login.login_admin_app');
    }

    public function cek_login_admin_app(Request $request){
        $request->validate([
            'nip_admin_app'=>'required',
            'password_admin_app'=>'required',
        ],[
            'nip_admin_app.required'=>'NIP tidak boleh kosong',
            'password_admin_app.required'=>'Password tidak boleh kosong',
        ]);
        $cek_login = AdminApp::where('nip_admin_app','=',$request->nip_admin_app)->first();
        if($cek_login){
            if(Hash::check($request->password_admin_app,$cek_login->password_admin_app)){
                $request->session()->put('LoggedAdminApp',$cek_login->id);
                return redirect('dashboard_admin_app');
            }else{
                $notification = array(
                    'error' => 'Password salah!',
                );
                return Redirect::to('login_admin_app')->with($notification);
            }
        }else{
            $notification = array(
                'error' => 'NIP tidak ditemukan!',
            );
            return Redirect::to('login_admin_app')->with($notification);
        }
    }

    public function dashboard_admin_app(){
        if (session()->has('LoggedAdminApp')){
            $data_admin_untuk_dashboard = AdminApp::where('id','=',session('LoggedAdminApp'))->first();
            $data = [
                'LoggedUserInfo'=>$data_admin_untuk_dashboard,
            ];
            return view('dashboard.dashboard_admin_app',$data);
        }else{
            return view('login.login_admin_app');
        }
    }

    public function logout_admin_app(){
        if (session()->has('LoggedAdminApp')){
            session()->pull('LoggedAdminApp');
            return redirect('login_admin_app');
        }else{
            return view('login.login_admin_app');
        }
    }

    public function tampil_data_profil_admin_app_oleh_admin_app(){
        if (session()->has('LoggedAdminApp')){
            $data_admin_untuk_dashboard = AdminApp::where('id','=',session('LoggedAdminApp'))->first();
            $data = [
                'LoggedUserInfo'=>$data_admin_untuk_dashboard,
            ];
            return view('tampil_data_oleh_admin_app.tampil_data_profil_admin_app_oleh_admin_app',$data);
        }else{
            return view('login.login_admin_app');
        }
    }

    public function simpan_perubahan_data_profil_admin_app(Request $request){
        if (session()->has('LoggedAdminApp')){
            $request->validate([
                'nama_admin_app'=>'required',
            ],[
                'nama_admin_app.required'=>'Nama tidak boleh kosong',
            ]);
            $admin_data = AdminApp::find($request->id);
            $admin_data->nama_admin_app = $request->nama_admin_app;
            $admin_data->save();
            return redirect('dashboard_admin_app');
        }else{
            return view('login.login_admin_app');
        }
    }

    public function simpan_perubahan_data_password_admin_app(Request $request){
        if (session()->has('LoggedAdminApp')){
            $request->validate([
                'password_baru'=>'required',
            ],[
                'password_baru.required'=>'Password tidak boleh kosong',
            ]);
            $admin_data = AdminApp::find($request->id);
            $admin_data->password_admin_app = Hash::make($request->password_baru);
            $admin_data->save();
            return redirect('dashboard_admin_app');
        }else{
            return view('login.login_admin_app');
        }
    }

    public function simpan_perubahan_data_foto_admin_app(Request $request){
        if (session()->has('LoggedAdminApp')){
            $admin_data = AdminApp::find($request->id);
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);
            $extension = $request->file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $request->file->move(public_path('foto_admin_app'),$filename);
            $data = $filename;
            $admin_data->foto_admin_app = $data;
            $admin_data->save();
            return redirect('dashboard_admin_app');
        }else{
            return view('login.login_admin_app');
        }
    }


}
