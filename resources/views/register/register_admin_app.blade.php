@extends('masterlayout.master_layout_backend')
@section('content')
    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <img src="{{asset('logo')}}/ksb.png" alt="User Image" height="100px"><br>
                    <br>
                    <a href="#" class="h5">Aplikasi Desa Cantik</a><br>
                    <small>Kabupaten Sumbawa Barat</small>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Register Admin App</p>
                    <form action="{{route('simpan_data_admin_app_baru')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="number" name="nip_admin_app" class="form-control @error('nip_admin_app') is-invalid @enderror" placeholder="Masukkan NIP" value="{{old('nip_admin_app')}}">
                            @error('nip_admin_app')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama_admin_app" class="form-control @error('nama_admin_app') is-invalid @enderror" placeholder="Masukkan Nama" value="{{old('nama_admin_app')}}">
                            @error('nama_admin_app')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password_admin_app" class="form-control @error('password_admin_app') is-invalid @enderror" placeholder="Masukkan Password" value="{{old('password_admin_app')}}">
                            @error('password_admin_app')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection